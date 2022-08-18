<?php

namespace App\Services;

use App\Models\JwtTokens;
use App\Models\User;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use RuntimeException;

class JwtService
{
    private $privateKey;
    private $publicKey;
    public $uuid;           // needed to create the token
    private $config;
    public $user;
    public $expiryTime;


    public function __construct()
    {
        $this->privateKey = InMemory::base64Encoded(base64_encode(env('JWT_PRIVATE_KEY')));
        $this->publicKey = InMemory::base64Encoded(base64_encode(env('JWT_PUBLIC_KEY')));
        // $this->uuid = $this->uuid;
        $this->config = Configuration::forAsymmetricSigner(new Sha256(), $this->privateKey, $this->publicKey);
    }

    public function validateToken($token)
    {
        // parse token and get user uuid
        $retrievedToken = $this->config->parser()->parse($token);
        $decodeUuid = base64_decode($retrievedToken->claims()->toString());
        $userUuid = json_decode($decodeUuid);
        $this->uuid = $userUuid->uuid;
        // check if token exists in the database
        $userToken = JwtTokens::with(['user'])->where(['unique_id' => $token, 'last_used_at' => null])->first();
        if ($userToken) {
            $this->uuid = $userUuid->uuid;
            // $this->expiryTime = $userUuid->exp;
            return true;
        }
        return false;
    }

    public function getUserTokenUuid($token): string
    {
        if ($this->validateToken($token)) {
            return $this->uuid;
        }
        return 'User token not found';
    }

    public function checkIfTokenIsAdmin($token): bool
    {
        if ($this->validateToken($token)) {
            $user = User::where(['uuid' => $this->uuid, 'is_admin' => 1])->first();
            if ($user) {
                $this->user = $user;
                return true;
            }
            return false;
        }

        return false;
    }

    public function checkIfTokenIsUser($token): bool
    {

        if ($this->validateToken($token)) {
            $user = User::where(['uuid' => $this->uuid, 'is_admin' => 0])->first();
            if ($user) {
                $this->user = $user;
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function checkIfTokenIsExpired($token): bool
    {
        // if ($this->validateToken($token)) {
        $token = JwtTokens::where(['unique_id' => $token, 'last_used_at' => null])->first();
        if ($token) {
            $expiryDate = Carbon::parse($token->expires_at);
            $currentDate = Carbon::now();
            if ($expiryDate < $currentDate) {
                return true;
            }
            return false;
        }
        // }
        return false;
    }

    public function refreshToken($token): void
    {
        // check if token is expired
        if ($this->checkIfTokenIsExpired($token)) {
            // update refreshed at date
            $date = Carbon::now();
            $token = JwtTokens::where(['unique_id' => $token, 'last_used_at' => null])->update(['expires_at' => $date->addHour(), 'refreshed_at' => $date]);
        }
    }

    public function createToken($uuid): string
    {
        $now = new DateTimeImmutable();
        $token = $this->config->builder()
            ->issuedBy(env('APP_URL'))
            ->withHeader('alg', 'ES256')
            ->withHeader('typ', 'JWT')
            ->withClaim('uuid', $uuid)
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->getToken($this->config->signer(), $this->config->signingKey());

        $this->expiryTime = $now->modify('+1 hour');

        return $token->toString();
    }

    public function resetPasswordToken($uuid): string
    {
        $now = new DateTimeImmutable();
        $token = $this->config->builder()
            ->issuedBy(env('APP_URL'))
            ->withHeader('alg', 'ES256')
            ->withHeader('typ', 'JWT')
            ->withClaim('uuid', $uuid)
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->getToken($this->config->signer(), $this->config->signingKey());

        $this->expiryTime = $now->modify('+1 hour');

        return $token->toString();
    }

    static public function unsetToken($token): bool
    {
        if ($token != '') {
            $date = Carbon::now();
            $token = JwtTokens::where(['unique_id' => $token, 'last_used_at' => null])->update(['last_used_at' => $date]);
            return true;
        }
        return false;
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $creditCardDetails = json_encode(array('holder_name' => fake()->name(), 'number' => fake()->creditCardNumber(), 'ccv' => fake()->numerify('###'), 'expire_date' => fake()->creditCardExpirationDate()));

        $cashOnDeliveryDetails = json_encode(["first_name" => fake()->firstName(), "last_name" => fake()->lastName, "address" => fake()->address]);

        $bankTransferDetails = json_encode(["swift" => fake()->swiftBicNumber(), "iban" => fake()->iban(), "name" => fake()->name]);

        $paymentTypes = ['credit_card' => $creditCardDetails, 'cash_on_delivery' =>  $cashOnDeliveryDetails, 'bank_transfer' => $bankTransferDetails];

        $seedingCount = 30;
        $seedingIterator = 0;
        while ($seedingIterator < $seedingCount) {
            foreach ($paymentTypes as $key => $value) {
                # code...
                DB::table('payments')->insert([
                    'uuid' => Str::uuid(),
                    'type' => $key,
                    'details' => $value,
                    'created_at' =>  now(),
                    'updated_at' =>  now(),
                ]);
            }
            $seedingIterator++;
        }
    }
}

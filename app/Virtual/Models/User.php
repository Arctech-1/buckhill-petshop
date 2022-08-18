<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="First Name",
     *      description="First name of the user",
     *      example="Reuben"
     * )
     *
     * @var string
     */
    public $first_name;


    /**
     * @OA\Property(
     *      title="Last Name",
     *      description="Last name of the user",
     *      example="Arinze"
     * )
     *
     * @var string
     */
    public $last_name;



    /**
     * @OA\Property(
     *      title="Email",
     *      description="User's email",
     *      example="arinzereuben@outlook.com"
     * )
     *
     * @var string
     */

    public $email;


    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */

    public $email_verified_at;



    /**
     * @OA\Property(
     *      title="Password",
     *      description="Enter password",
     *      example="paSswordD"
     * )
     *
     * @var string
     */

    public $password;


    /**
     * @OA\Property(
     *      title="Avatar",
     *      description="Enter image uuid ",
     *      example="paSswordD"
     * )
     *
     * @var string
     */


    public $avatar;

    /**
     * @OA\Property(
     *      title="Address",
     *      description="Enter user's address ",
     *      example="63 lekki phase 1 Lagos"
     * )
     *
     * @var string
     */

    public $address;

    /**
     * @OA\Property(
     *      title="Phone number",
     *      description="Enter phone number ",
     *      example="080474758947342"
     * )
     *
     * @var string
     */
    public $phone_number;

    /**
     * @OA\Property(
     *      title="Marketing",
     *      description="Enter 0 or 1 ",
     *      example="1"
     * )
     *
     * @var integer
     */

    public $is_marketing;


    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */

    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */

    private $deleted_at;


    /**
     * @OA\Property(
     *     title="Last Login at",
     *     description="Logged in at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */


    public $last_login_at;
}

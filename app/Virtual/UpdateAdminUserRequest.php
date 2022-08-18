<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Update User request",
 *      description="Update User request body data",
 *      type="object",
 *      required={"name"}
 * )
 */



class UpdateAdminUserRequest
{
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
}

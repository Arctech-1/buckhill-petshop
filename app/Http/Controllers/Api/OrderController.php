<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Services\JwtService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.api')->only('userOrders');
        $this->middleware('roleUser.api')->only('userOrders');
    }


    /**
     * Get logged in user customer
     *
     * @return \Illuminate\Http\Response
     */

    public function userOrders(Request $request)
    {
        // requet paramfa
        $orderBy = $request->query('sortBy') ??
            $limit =  $request->query('Limit') ?? 3;
        $descOrAsc = $request->query('Limit') ? 'desc' : 'asc';

        $jwt = new JwtService;
        $uuid = $jwt->getUserTokenUuid($request->bearerToken());
        $orders = Orders::where('uuid', $uuid)->orderBy($orderBy, $descOrAsc)->paginate($limit);
        if (!$orders['data']) {
            return response()->json(['error' => ['message' => 'No orders found']], 404);
        }

        return response()->json(['data' => ['orders' => $orders]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

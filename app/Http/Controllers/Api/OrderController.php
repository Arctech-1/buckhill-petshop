<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use App\Services\JwtService;
use Illuminate\Http\Request;
use PDF;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.api')->only(['userOrders', 'downloadOrderInvoice']);
        $this->middleware('roleUser.api')->only(['userOrders', 'downloadOrderInvoice']);
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
        $user = User::where('uuid', $uuid)->first();
        $orders = $user->orders()->orderBy($orderBy, $descOrAsc)->paginate($limit);
        // $orders = Orders::where('user_id', $uuid)->orderBy($orderBy, $descOrAsc)->paginate($limit);
        if (!$orders['data']) {
            return response()->json(['error' => ['message' => 'No orders found']], 404);
        }

        return response()->json(['data' => ['orders' => $orders]]);
    }

    /**
     * download user order invoice
     *
     * @return \Illuminate\Http\Response
     */

    public function downloadOrderInvoice(Request $request, $uuid)
    {
        $order = Orders::where('uuid', $uuid)->first();

        $items = json_decode($order->products);
        $products = [];
        foreach ($items as $item) {
            $prod = Products::select('title', 'price')->where('uuid', $item->product)->first();
            array_push($products,  ['product' => $prod, 'quantity' => $item->quantity]);
        }
        $invoiceNumber = random_int(100000, 999999);
        $data = ['order' => $order, 'invoiceNumber' => $invoiceNumber, 'products' => $products];
        $pdf = PDF::loadView('myPDF', $data);
        return $pdf->download($uuid . '.pdf');
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

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice - #123</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .invoice table {
            margin: 15px;
        }

        .invoice h3 {
            margin-left: 15px;
        }

        .information {
            background-color: #60A7A6;
            color: #FFF;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }
    </style>

</head>

<body>
    @php
    $address = json_decode($order->address)
    @endphp
    <div class="information">
        <table width="100%">
            <tr>
                <td align="left" style="width: 40%;">
                    <h3> {{ $order->user->first_name }} {{ $order->user->last_name }}</h3>
                    <pre> Shipping Address: {{ $address->shipping}} <br/>Biling Address: {{ $address->billing }}
                            <br /><br />
                            Date: {{ $order->created_at }}
                            Identifier: #uniquehash
                            Status: Paid
                            </pre>

                </td>
                <td align="center">
                    <img src="/path/to/logo.png" alt="Logo" width="64" class="logo" />
                </td>
                <td align="right" style="width: 40%;">

                    <h3>Store Name</h3>
                    <pre>Buckhill Pet ShopStreet 26123456 CityUnited Kingdom
                </pre>
                </td>
            </tr>

        </table>
    </div>


    <br />

    <div class="invoice">
        <h3>Invoice Number #{{ $invoiceNumber }}</h3>
        <table width="100%">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $items)
                <tr>
                    <td>{{ $items['product']->title }}</td>
                    <td>{{ $items['quantity'] }}</td>
                    <td align="left">€{{ $items['product']->price }}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="1"></td>
                    <td align="left">Total</td>
                    <td align="left" class="gray">€ {{ $order->amount }}</td>
                </tr>
            </tfoot>
        </table>
        <h6> <strong>Delivery Fee: </strong>€ {{ $order->delivery_fee }}</h6>
    </div>


    <div class="information" style="position: absolute; bottom: 0;">
        <table width="100%">
            <tr>
                <td align="left" style="width: 50%;">
                    &copy; {{ date('Y') }} {{ config('app.url') }} - All rights reserved.
                </td>
                <td align="right" style="width: 50%;">
                    Buckhill Pet Shop
                </td>
            </tr>

        </table>
    </div>
</body>

</html>


{{--
<!DOCTYPE html>
<html>

<head>
    <title>Laravel 9 Generate and Save PDF Example - codecheef.org</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <h1>{{ $order->title }}</h1>
    <p>{{ $order->created_at }}</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua.</p>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        @foreach($products as $items)
        <tr>
            <td>{{ $items['product']->title }}</td>
            <td>{{ $items['quantity'] }}</td>
        </tr>

        @endforeach
    </table>


    <table class="table table-bordered">
        <tr>
            <th>Address</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        @php
        $address = json_decode($order->address)
        @endphp
        <tr>
            <td>{{ $address->shipping}}</td>
            <br>
            <td>{{ $address->billing}}</td>
        </tr>

    </table>

</body>

</html> --}}
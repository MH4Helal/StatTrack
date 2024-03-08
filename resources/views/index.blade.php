<!DOCTYPE html>
<body>
    <h1>Sales Statistics</h1>
    @foreach($statistics as $date => $data)
        <h2>{{ $date }}</h2>
        <h3>Sales Agents</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Total Sales</th>
                <th>Total Price</th>
            </tr>
            @foreach($data['sales_agents'] as $agent)
                <tr>
                    <td>{{ $agent->sales_agent }}</td>
                    <td>{{ $agent->total_sales }}</td>
                    <td>{{ $agent->total_price }}</td>
                </tr>
            @endforeach
        </table>

        <h3>Products</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Total Sales</th>
                <th>Total Price</th>
            </tr>
            @foreach($data['products'] as $product)
                <tr>
                    <td>{{ $product->product }}</td>
                    <td>{{ $product->total_sales }}</td>
                    <td>{{ $product->total_price }}</td>
                </tr>
            @endforeach
        </table>

        <h3>Customers</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Total Sales</th>
                <th>Total Price</th>
            </tr>
            @foreach($data['customers'] as $customer)
                <tr>
                    <td>{{ $customer->customer }}</td>
                    <td>{{ $customer->total_sales }}</td>
                    <td>{{ $customer->total_price }}</td>
                </tr>
            @endforeach
        </table>
    @endforeach
</body>

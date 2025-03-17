<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn bạn đã đặt hàng</title>
</head>
<body style="background-color: #f3f3f3; padding: 10px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <p style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">Xin chào {{ $name }},</p>
        
        <p style="margin-bottom: 20px;">Cảm ơn bạn đã đặt hàng từ chúng tôi. Đơn hàng của bạn đã được nhận và đang được xử lý. Dưới đây là chi tiết đơn hàng:</p>

        <p style="margin-bottom: 10px;">Mã đơn hàng: {{ $order->id }}</p>
        <p style="margin-bottom: 10px;">Thời gian đặt hàng lúc: {{ $order->created_at }}</p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Sản phẩm</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Số lượng</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Đồ ăn gọi thêm</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($selectedProducts as $product)
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $product['products']['name'] }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $product['quantity'] }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            @foreach ($product['toppings'] as $topping)
                                {{ $topping['name'] }},
                            @endforeach
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format($product['total_price'], 2, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-bottom: 20px;">Tổng số tiền: {{ number_format($order->total_price, 2, ',', '.') }} VND</p>
        <p style="margin-bottom: 20px;">Phương thức thanh toán: {{ $order->payment_method }}</p>

        <p style="margin-bottom: 20px;">Cảm ơn bạn một lần nữa và chúng tôi hy vọng bạn sẽ hài lòng với sản phẩm của mình.</p>

        <p style="margin-bottom: 0;">Trân trọng,<br>
        Top Food</p>
    </div>
</body>
</html>

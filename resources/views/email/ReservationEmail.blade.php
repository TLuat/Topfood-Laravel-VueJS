<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn bạn đã đặt bàn</title>
</head>
<body style="background-color: #f3f3f3; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <p style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">Xin chào {{ $name }},</p>
        
        <p style="margin-bottom: 20px;">Cảm ơn bạn đã đặt bàn từ chúng tôi. Đơn đặt bàn của bạn đã được nhận và đang được xử lý. Dưới đây là chi tiết đơn hàng:</p>

        <p style="margin-bottom: 10px;">Bàn đã đặt: {{ $table->name }}</p>
        <p style="margin-bottom: 10px;">Họ tên: {{ $reservation->name }}</p>
        <p style="margin-bottom: 10px;">Ngày đặt: {{ $reservation->res_date }}, lúc  {{ $reservation->time }}</p>
        <p style="margin-bottom: 10px;">Số người: {{ $reservation->guest_number }}</p>
        <p style="margin-bottom: 10px;">Tổng giá: {{  number_format($reservation->total_price, 2, ',', '.')  }} VND</p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Thực đơn</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Số lượng</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($selectedMenuItems as $menu)
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $menu['name'] }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $menuQuantities[$menu['id']] }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format($menu['price'], 2, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-bottom: 20px;">Cảm ơn bạn một lần nữa và chúng tôi hy vọng bạn sẽ hài lòng với sản phẩm của mình.</p>

        <p style="margin-bottom: 0;">Trân trọng,<br>
        Top Food</p>
    </div>
</body>
</html>

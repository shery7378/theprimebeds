<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Ready for Collection</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr style="background-color: #002B45;">
            <td style="padding: 20px; text-align: center; color: #ffffff; font-size: 22px; font-weight: bold;">
               Sign and Print Creation
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <h2 style="color: #333;">Dear {{$shippingInfo['ship_last_name']}}</h2>
                <p style="font-size: 16px; color: #555;">
                    We are pleased to inform you that your order is now <strong>complete</strong> and ready for
                    collection from
                    <strong>Sign and Print Creation</strong>.
                </p>
                <p style="font-size: 16px; color: #555;">
                    Our team has carefully produced and quality-checked your items to ensure they meet our high
                    standards.
                    You are welcome to collect your order at your earliest convenience.
                </p>
                <h3 style="color: #333; margin-top: 30px;">Collection Details:</h3>
                <ul style="list-style: none; padding: 0; font-size: 16px; color: #555;">
                    <li><strong>Order Number:</strong> {{$deliveryInfo['order_number']}}</li>
                    <li><strong>Pickup Location:</strong> {{$deliveryInfo['pickup_location']}}</li>
                    <li><strong>Opening Hours:</strong> {{$deliveryInfo['opening_hours']}}</li>
                    <li><strong>Contact Number:</strong> {{$deliveryInfo['contact_number']}}</li>
                </ul>

                <p style="font-size: 16px; color: #555;">
                    If you require assistance with directions, have any questions, or need to arrange a specific
                    collection time,
                    please don’t hesitate to get in touch with us:
                </p>

                <table style="width: 100%; margin-top: 10px; font-size: 16px; color: #555;">
                    <tr>
                        <td>📧 <strong>Email:</strong></td>
                        <td>{{$setting->contact_mail}}</td>
                    </tr>
                    <tr>
                        <td>📞 <strong>Phone:</strong></td>
                        <td>{{$setting->contact_number}}</td>
                    </tr>
                    <tr>
                        <td>💬 <strong>WhatsApp:</strong></td>
                        <td>{{$setting->whatsapp}}</td>
                    </tr>
                </table>

                <p style="font-size: 16px; color: #555; margin-top: 30px;">
                    Thank you for choosing <strong>Sign and Print Creation</strong>. We appreciate your business and
                    look forward to serving you again.
                </p>

                <p style="font-size: 16px; color: #555;">
                    Kind regards,<br>
                    <strong>The Sign and Print Creation Team</strong>
                </p>

                <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
                <p style="text-align: center; margin-top: 30px;">
                    <a href="{{ url('/') }}"
                        style="display: inline-block; padding: 12px 24px; background-color: {{$setting->primary_color}}; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px;">
                        Visit Our Website
                    </a>
                    |
                    {{$setting->title}} |
                    {{$setting->contact_number}} |
                   {{$setting->contact_mail}}
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
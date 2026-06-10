<html>

<head>
    <meta charset="UTF-8">
    <title>Order Dispatched</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; color: #333;">
    <table align="center" width="600"
        style="background-color: #fff; border-radius: 6px; overflow: hidden; box-shadow: 0 0 8px rgba(0,0,0,0.1);">
        <tr style="background-color: #002B45;">
            <td style="padding: 20px; text-align: center; color: #ffffff; font-size: 22px; font-weight: bold;">
                Sign and Print Creation
            </td>
        </tr>

        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 16px;">Dear <strong>{{$shipping_info['ship_last_name']}}</strong>,</p>

                <p style="font-size: 16px; margin-top: 15px;">We’re pleased to inform you that your order with
                    <strong> Sign and Print Creation</strong> is now complete and has been dispatched.
                </p>

                <p style="font-size: 16px;">Your custom-made <strong>signs, prints, or packaging</strong> have been
                    carefully produced, quality-checked, and securely packed to ensure they arrive in excellent
                    condition. Our team takes great pride in delivering precision-crafted products that reflect your
                    brand and our commitment to excellence.</p>

                <h3 style="color: #002B45;">Delivery Details:</h3>
                <ul style="font-size: 16px; line-height: 1.6;">
                    <li><strong>Courier:</strong> {{$deliveryInfo['courier_name']}}</li>
                    <li><strong>Tracking Number:</strong> {{$deliveryInfo['tracking_number']}}</li>
                    <li><strong>Track Your Order:</strong> <a href="{{$deliveryInfo['tracking_link']}}"
                            style="color: {{$setting->primary_color}}; text-decoration: none;">Click Here</a></li>
                    <li><strong>Estimated Delivery Date:</strong> {{$deliveryInfo['delivery_date']}}</li>
                </ul>

                <p style="font-size: 16px;">You can track your delivery using the link above. If you have any questions
                    or need help with future orders, feel free to contact us:</p>

                <p style="font-size: 16px;">
                    <strong>Email:</strong> <a href="mailto:sales@signandprintcreation.co.uk"
                        style="color: {{$setting->primary_color}};">sales@signandprintcreation.co.uk</a><br>
                    <strong>Phone 1:</strong> {{$setting->contact_number}}<br>
                    <strong>Phone 2:</strong> {{$setting->footer_phone}}
                </p>

                <p style="font-size: 16px;">Thank you for choosing  Signs and Print. We truly value your
                    business and look forward to supporting your future projects.</p>

                <p style="font-size: 16px;">With kind regards,<br><br>
                    <strong>Sign & Print Creation Team</strong><br>
                    <em>Signs - Prints - Custom Boxes</em>
                </p>

                <p style="text-align: center; margin-top: 30px;">
                    <a href="{{ url('/') }}"
                        style="display: inline-block; padding: 12px 24px; background-color: {{$setting->primary_color}}; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px;">
                        Visit Our Website
                    </a>
                </p>
            </td>
        </tr>

        <tr style="background-color: #f4f4f4;">
            <td style="text-align: center; padding: 15px; font-size: 13px; color: #999;">
                &copy; {{ date('Y') }} Sign and Print Creation. All rights reserved.
            </td>
        </tr>

        <tr>
            <td style="padding: 20px; background-color: #f9f9f9; text-align: center; color: #888; font-size: 13px;">
                Thanks,<br>
                {{ config('app.name') }}
            </td>
        </tr>
    </table>
</body>

</html>
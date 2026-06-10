
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Cancelled</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                    <tr>
                        <td style="padding: 30px; background-color: {{$setting->primary_color}}; color: #ffffff; text-align: center;">
                            <h2 style="margin: 0;">Order Cancelled</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px; color: #333;">
                            <p style="font-size: 16px;">Dear <strong>{{ $shippingInfo['ship_last_name'] }}</strong>,</p>

                            <p style="font-size: 15px; line-height: 1.6;">
                                We’re writing to inform you that your recent order <strong>{{ $order->transaction_number ?? 'N/A'}}</strong> with 
                                <strong>Sign and Print Creation</strong> has been marked as 
                                <strong style="color: #f44336;">cancelled</strong> in our system.
                            </p>

                            <p style="font-size: 15px;">This may have occurred due to one of the following reasons:</p>

                            <ul style="font-size: 15px; padding-left: 20px;">
                                <li>Payment was not successfully processed</li>
                                <li>Required artwork or information was not received</li>
                                <li>A cancellation was requested</li>
                                <li>A technical or submission error occurred</li>
                            </ul>

                            <p style="font-size: 15px; line-height: 1.6;">
                                Please rest assured, our team will be reaching out to you shortly via email or phone to clarify the situation and discuss possible next steps.
                                If this cancellation was unintentional, we’ll be happy to assist in reinstating the order or creating a revised quote.
                            </p>

                            <p style="font-size: 15px;">
                                If you have any immediate questions or would like to speak to someone sooner, please don’t hesitate to contact us.
                            </p>

                            <p style="text-align: center; margin-top: 30px;">
                                <a href="{{ url('/') }}" style="display: inline-block; padding: 12px 24px; background-color: {{$setting->primary_color}}; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px;">
                                    Visit Our Website
                                </a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; background-color: #f9f9f9; text-align: center; color: #888; font-size: 13px;">
                            Thanks,<br>
                            {{ config('app.name') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

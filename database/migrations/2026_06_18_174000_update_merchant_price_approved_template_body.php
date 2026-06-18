<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('email_templates')
            ->where('type', 'Merchant Price Approved')
            ->update([
                'body' => '<div style="background-color: #f8f6f0; padding: 50px 20px; font-family: \'Outfit\', \'Inter\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; margin: 0; width: 100%; min-height: 100%; box-sizing: border-box;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 45px rgba(140, 117, 88, 0.1); border: 1px solid #eae5db; margin: 0 auto;">
        <!-- Header Banner -->
        <tr>
            <td align="center" style="background-color: #0f172a; padding: 45px 20px; border-bottom: 5px solid #8c7558;">
                <div style="font-size: 24px; font-weight: 700; color: #ffffff; letter-spacing: 4px; text-transform: uppercase; margin: 0; line-height: 1.2; font-family: inherit;">
                    The Prime Beds
                </div>
                <div style="font-size: 11px; font-weight: 600; color: #8c7558; letter-spacing: 3px; text-transform: uppercase; margin-top: 10px; margin-bottom: 0; font-family: inherit;">
                    Merchant Partnership
                </div>
            </td>
        </tr>
        
        <!-- Content Area -->
        <tr>
            <td style="padding: 50px 40px; background-color: #ffffff;">
                <!-- Congratulations Badge & Heading -->
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 25px; margin-left: auto; margin-right: auto;">
                    <tr>
                        <td align="center" style="background-color: #fbf9f5; border: 2px solid #eae5db; width: 72px; height: 72px; border-radius: 50%; display: inline-block; text-align: center; vertical-align: middle;">
                            <span style="font-size: 32px; line-height: 68px; color: #8c7558; font-family: inherit;">✓</span>
                        </td>
                    </tr>
                </table>
                
                <h2 style="color: #0f172a; margin-top: 0; margin-bottom: 16px; font-size: 24px; font-weight: 700; text-align: center; letter-spacing: -0.5px; line-height: 1.3; font-family: inherit;">
                    Proposal Approved!
                </h2>
                
                <p style="color: #475569; font-size: 15px; line-height: 1.6; text-align: center; margin-top: 0; margin-bottom: 35px; font-family: inherit;">
                    Great news, <strong>{user_name}</strong>! Your proposed merchant price has been successfully approved by the administration. The product is now live with your custom pricing.
                </p>
                
                <!-- Product Details Box -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fbfaf8; border-radius: 16px; border: 1px solid #f2ede4; overflow: hidden; margin-bottom: 35px;">
                    <tr>
                        <td style="padding: 25px 30px;">
                            <h3 style="color: #8c7558; font-size: 13px; font-weight: 700; margin-top: 0; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px; font-family: inherit;">
                                Proposal Summary
                            </h3>
                            
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <!-- Product Name -->
                                <tr>
                                    <td style="padding: 12px 0; color: #64748b; font-size: 14px; border-bottom: 1px solid #f1ece4; vertical-align: top; width: 40%; font-family: inherit;">
                                        <strong>Product Name</strong>
                                    </td>
                                    <td style="padding: 12px 0; color: #0f172a; font-size: 14px; font-weight: 600; text-align: right; border-bottom: 1px solid #f1ece4; vertical-align: top; width: 60%; font-family: inherit;">
                                        {product_name}
                                    </td>
                                </tr>
                                <!-- Base Price -->
                                <tr>
                                    <td style="padding: 12px 0; color: #64748b; font-size: 14px; border-bottom: 1px solid #f1ece4; vertical-align: middle; font-family: inherit;">
                                        <strong>Base Price</strong>
                                    </td>
                                    <td style="padding: 12px 0; color: #64748b; font-size: 14px; font-weight: 500; text-decoration: line-through; text-align: right; border-bottom: 1px solid #f1ece4; vertical-align: middle; font-family: inherit;">
                                        {base_price}
                                    </td>
                                </tr>
                                <!-- Proposed Price -->
                                <tr>
                                    <td style="padding: 12px 0; color: #64748b; font-size: 14px; border-bottom: 1px solid #f1ece4; vertical-align: middle; font-family: inherit;">
                                        <strong>Approved Price</strong>
                                    </td>
                                    <td style="padding: 12px 0; color: #059669; font-size: 18px; font-weight: 700; text-align: right; border-bottom: 1px solid #f1ece4; vertical-align: middle; font-family: inherit;">
                                        {proposed_price}
                                    </td>
                                </tr>
                                <!-- Status -->
                                <tr>
                                    <td style="padding: 12px 0; color: #64748b; font-size: 14px; vertical-align: middle; font-family: inherit;">
                                        <strong>Status</strong>
                                    </td>
                                    <td style="padding: 12px 0; text-align: right; vertical-align: middle; font-family: inherit;">
                                        <span style="background-color: #e6f4ea; color: #137333; padding: 4px 12px; border-radius: 20px; border: 1px solid #ceead6; font-size: 12px; font-weight: 700; display: inline-block; font-family: inherit;">
                                            Live & Active
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <!-- Action Button -->
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 35px; margin-left: auto; margin-right: auto;">
                    <tr>
                        <td align="center" style="background-color: #8c7558; border-radius: 30px; overflow: hidden; box-shadow: 0 4px 12px rgba(140, 117, 88, 0.25);">
                            <a href="{site_url}/admin" target="_blank" style="display: inline-block; padding: 16px 36px; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; font-family: inherit;">
                                Go to Dashboard
                            </a>
                        </td>
                    </tr>
                </table>
                
                <p style="color: #94a3b8; font-size: 13px; line-height: 1.5; text-align: center; margin: 0; font-family: inherit;">
                    If you have any questions or require assistance, please contact the vendor support team.
                </p>
            </td>
        </tr>
        
        <!-- Footer -->
        <tr>
            <td style="background-color: #0f172a; padding: 35px; text-align: center; border-top: 1px solid #1e293b;">
                <p style="color: #94a3b8; font-size: 12px; margin: 0; font-weight: 500; font-family: inherit;">
                    &copy; ' . date('Y') . ' {site_title}. All rights reserved.
                </p>
                <p style="color: #475569; font-size: 11px; margin: 8px 0 0 0; line-height: 1.4; font-family: inherit;">
                    You are receiving this automated email notification because you are registered as a merchant partner. Please do not reply directly to this message.
                </p>
            </td>
        </tr>
    </table>
</div>'
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down migration logic needed for simple template text update
    }
};

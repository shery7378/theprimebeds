<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateEmailTemplatesBodyForGlobalLayout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $orderTemplate = DB::table('email_templates')->where('type', 'Order')->first();
        if ($orderTemplate) {
            DB::table('email_templates')->where('type', 'Order')->update([
                'body' => '<h2 style="color: #333333; margin-top: 0;">Thank You For Your Order!</h2>
<p>Hello <strong>{user_name}</strong>,</p>
<p>Your order has been placed successfully.</p>
<p><strong>Order Number:</strong> {transaction_number}</p>
<p>We will notify you once your order is shipped.</p>'
            ]);
        }

        $registrationTemplate = DB::table('email_templates')->where('type', 'Registration')->first();
        if ($registrationTemplate) {
            DB::table('email_templates')->where('type', 'Registration')->update([
                'body' => '<h2 style="color: #333333; margin-top: 0;">Welcome to {site_title}!</h2>
<p>Hello <strong>{user_name}</strong>,</p>
<p>You have successfully registered to {site_title}. We are thrilled to have you on board and wish you a wonderful experience using our services.</p>
<p>Thank You!</p>'
            ]);
        }

        $newOrderAdminTemplate = DB::table('email_templates')->where('type', 'New Order Admin')->first();
        if ($newOrderAdminTemplate) {
            DB::table('email_templates')->where('type', 'New Order Admin')->update([
                'body' => '<h2 style="color: #333333; margin-top: 0;">New Order Received</h2>
<p>Hello Admin,</p>
<p>You have received a new order.</p>
<p><strong>Transaction Number:</strong> {transaction_number}</p>
<p>Please log in to the admin panel to view the details.</p>'
            ]);
        }

        $merchantTemplate = DB::table('email_templates')->where('type', 'Merchant Price Approved')->first();
        if ($merchantTemplate) {
            DB::table('email_templates')->where('type', 'Merchant Price Approved')->update([
                'body' => '<div style="text-align: center; margin-bottom: 20px;">
    <span style="font-size: 32px; color: #059669;">✓</span>
</div>
<h2 style="color: #333333; margin-top: 0; text-align: center;">Proposal Approved!</h2>
<p style="text-align: center;">Great news, <strong>{user_name}</strong>! Your proposed merchant price has been successfully approved. The product is now live with your custom pricing.</p>
<div style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; margin-top: 20px;">
    <h3 style="margin-top: 0; border-bottom: 1px solid #eeeeee; padding-bottom: 10px;">Proposal Summary</h3>
    <p><strong>Product Name:</strong> {product_name}</p>
    <p><strong>Base Price:</strong> <span style="text-decoration: line-through;">{base_price}</span></p>
    <p><strong>Approved Price:</strong> <strong style="color: #059669; font-size: 18px;">{proposed_price}</strong></p>
</div>
<div style="text-align: center; margin-top: 30px;">
    <a href="{site_url}/admin" style="background-color: #333333; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold;">Go to Dashboard</a>
</div>'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Not necessary for this content update
    }
}

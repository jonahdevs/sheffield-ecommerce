<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->string('stripe_session_id')->nullable()->index()->after('checkout_request_id');
            $table->string('stripe_payment_intent_id')->nullable()->after('stripe_session_id');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['stripe_session_id']);
            $table->dropColumn(['stripe_session_id', 'stripe_payment_intent_id']);
            $table->string('phone')->nullable(false)->change();
        });
    }
};

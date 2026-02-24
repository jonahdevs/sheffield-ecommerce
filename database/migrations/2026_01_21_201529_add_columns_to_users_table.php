<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('email', function (Blueprint $table) {
                $table->string('phone_number', 20)->nullable();
                $table->string('phone_number_verified_at', 20)->nullable();
                $table->string('avatar')->nullable();
                $table->boolean('newsletter_subscribed')->default(value: false);
                $table->string('default_payment_method')->nullable();
                $table->boolean('is_staff')->default(false);
                $table->string('status')->default('active');
                $table->string('status_reason')->nullable();
                $table->timestamp('suspended_until')->nullable();
                $table->softDeletes();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'phone_number_verified_at',
                'avatar',
                'newsletter_subscribed',
                'default_payment_method',
                'preferred_shipping_method_id',
                'is_staff',
                'status',
                'status_reason',
                'suspended_until',
                'deleted_at',
            ]);
        });
    }
};

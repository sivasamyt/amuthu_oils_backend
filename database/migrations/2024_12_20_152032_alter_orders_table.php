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
        Schema::table('orders', function (Blueprint $table) {
            // Dropping existing columns
            $table->dropColumn(['details', 'client', 'delivery']);

            // Adding new columns
            $table->json('cart_ids')->nullable()->after('user_id'); // Array of cart IDs
            $table->enum('order_status', ['pending', 'completed', 'cancelled'])->default('pending')->after('cart_ids'); // Order status
            $table->decimal('amount', 10, 2)->after('order_status'); // Total amount
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Adding the dropped columns back
            $table->text('details')->nullable();
            $table->string('client')->nullable();
            $table->boolean('delivery')->default(false);

            // Dropping the newly added columns
            $table->dropColumn(['cart_ids', 'order_status', 'amount']);
        });
    }
};

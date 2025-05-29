<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closingamounts', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('enquiry_id');
        $table->date('voucher_date')->nullable();
        $table->string('payment_mode');
        
        // Cheque fields
        $table->string('cheque_bank')->nullable();
        $table->string('cheque_no_bank')->nullable();
        $table->date('cheque_date')->nullable();
        $table->date('cheque_reconciliation_date')->nullable();
        $table->text('cheque_description')->nullable();
        
        // Cash fields
        $table->string('cash_receive_by')->nullable();
        $table->date('cash_receive_date')->nullable();
        $table->text('cash_receive_description')->nullable();
        
        // Online payment fields
        $table->string('online_receive_by')->nullable();
        $table->string('online_bank')->nullable();
        $table->string('online_trn_upi_no')->nullable();
        $table->date('online_receive_date')->nullable();
        $table->text('online_receive_description')->nullable();
        
        // Other fields
        $table->decimal('total_amount_receive', 10, 2)->nullable();
        $table->text('message_note')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('closingamounts');
    }
};

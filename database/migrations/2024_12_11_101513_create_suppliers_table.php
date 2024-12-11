<?php

use App\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mantax559\LaravelHelpers\Helpers\TableHelper;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(TableHelper::getName(Supplier::class), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('vat_code')->nullable();
            $table->string('address');
            $table->string('responsible_person');
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->string('alternate_contact_phone')->nullable();
            $table->string('email');
            $table->string('alternate_email')->nullable();
            $table->string('billing_email');
            $table->string('alternate_billing_email')->nullable();
            $table->string('certificate_code');
            $table->boolean('is_fsc');
            $table->dateTime('validation_date');
            $table->dateTime('expiry_date');
            $table->longText('comments')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TableHelper::getName(Supplier::class));
    }
};

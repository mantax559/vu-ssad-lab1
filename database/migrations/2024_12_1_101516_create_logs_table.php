<?php

use App\Models\Log;
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
        Schema::create(TableHelper::getName(Log::class), function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('code')->unique();
            $table->longText('description');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TableHelper::getName(Log::class));
    }
};

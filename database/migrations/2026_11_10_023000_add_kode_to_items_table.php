<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('items', 'kode')) {
            Schema::table('items', function (Blueprint $table) {
                $table->string('kode')->nullable()->after('id');
            });

            // Isi kode otomatis untuk data lama jika ada yang masih kosong
            $existingItems = DB::table('items')->whereNull('kode')->orWhere('kode', '')->get();
            foreach ($existingItems as $item) {
                DB::table('items')
                    ->where('id', $item->id)
                    ->update(['kode' => 'KBH-' . str_pad($item->id, 4, '0', STR_PAD_LEFT)]);
            }

            // Pasang constraint UNIQUE setelah data aman terisi
            Schema::table('items', function (Blueprint $table) {
                $table->unique('kode');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('items', 'kode')) {
            Schema::table('items', function (Blueprint $table) {
                $table->dropColumn('kode');
            });
        }
    }
};


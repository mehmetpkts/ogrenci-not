<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1) Add columns as nullable to avoid failing on existing rows
        if (!Schema::hasColumn('egitmenler', 'egitmen_no')) {
            Schema::table('egitmenler', function (Blueprint $table) {
                $table->string('egitmen_no', 50)->nullable()->after('ad_soyad');
            });
        }
        if (!Schema::hasColumn('egitmenler', 'telefon_numarasi')) {
            Schema::table('egitmenler', function (Blueprint $table) {
                $table->string('telefon_numarasi', 11)->nullable()->after('egitmen_no');
            });
        }
        if (!Schema::hasColumn('egitmenler', 'okul_email')) {
            Schema::table('egitmenler', function (Blueprint $table) {
                $table->string('okul_email', 255)->nullable()->after('telefon_numarasi');
            });
        }

        // 2) Backfill existing rows with unique placeholder values (treat NULL and empty strings as missing)
        DB::table('egitmenler')->orderBy('id')
            ->select('id')
            ->lazyById()->each(function ($row) {
                DB::table('egitmenler')
                  ->where('id', $row->id)
                  ->update([
                      'egitmen_no' => DB::raw("CASE WHEN egitmen_no IS NULL OR egitmen_no = '' THEN CONCAT('E', LPAD(id, 6, '0')) ELSE egitmen_no END"),
                      'telefon_numarasi' => DB::raw("CASE WHEN telefon_numarasi IS NULL OR telefon_numarasi = '' THEN '00000000000' ELSE telefon_numarasi END"),
                      'okul_email' => DB::raw("CASE WHEN okul_email IS NULL OR okul_email = '' THEN CONCAT('egitmen', id, '@example.edu') ELSE okul_email END"),
                  ]);
            });

        // 3) Add unique indexes after data is backfilled
        Schema::table('egitmenler', function (Blueprint $table) {
            $table->unique('egitmen_no');
            $table->unique('okul_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('egitmenler', function (Blueprint $table) {
            $table->dropUnique('egitmenler_egitmen_no_unique');
            $table->dropUnique('egitmenler_okul_email_unique');
            $table->dropColumn(['egitmen_no', 'telefon_numarasi', 'okul_email']);
        });
    }
};

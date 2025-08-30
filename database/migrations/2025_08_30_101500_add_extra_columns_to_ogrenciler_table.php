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
        if (!Schema::hasColumn('ogrenciler', 'ogrenci_no')) {
            Schema::table('ogrenciler', function (Blueprint $table) {
                $table->string('ogrenci_no', 50)->nullable()->after('ad_soyad');
            });
        }
        if (!Schema::hasColumn('ogrenciler', 'telefon_numarasi')) {
            Schema::table('ogrenciler', function (Blueprint $table) {
                $table->string('telefon_numarasi', 11)->nullable()->after('ogrenci_no');
            });
        }
        if (!Schema::hasColumn('ogrenciler', 'okul_email')) {
            Schema::table('ogrenciler', function (Blueprint $table) {
                $table->string('okul_email', 255)->nullable()->after('telefon_numarasi');
            });
        }

        // 2) Backfill existing rows with unique placeholder values (treat NULL and empty strings as missing)
        DB::table('ogrenciler')->orderBy('id')
            ->select('id')
            ->lazyById()->each(function ($row) {
                DB::table('ogrenciler')
                  ->where('id', $row->id)
                  ->update([
                      'ogrenci_no' => DB::raw("CASE WHEN ogrenci_no IS NULL OR ogrenci_no = '' THEN CONCAT('O', LPAD(id, 6, '0')) ELSE ogrenci_no END"),
                      'telefon_numarasi' => DB::raw("CASE WHEN telefon_numarasi IS NULL OR telefon_numarasi = '' THEN '00000000000' ELSE telefon_numarasi END"),
                      'okul_email' => DB::raw("CASE WHEN okul_email IS NULL OR okul_email = '' THEN CONCAT('ogrenci', id, '@example.edu') ELSE okul_email END"),
                  ]);
            });

        // 3) Add unique indexes after data is backfilled
        Schema::table('ogrenciler', function (Blueprint $table) {
            $table->unique('ogrenci_no');
            $table->unique('okul_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ogrenciler', function (Blueprint $table) {
            // Drop indexes before columns
            $table->dropUnique('ogrenciler_ogrenci_no_unique');
            $table->dropUnique('ogrenciler_okul_email_unique');

            $table->dropColumn(['ogrenci_no', 'telefon_numarasi', 'okul_email']);
        });
    }
};

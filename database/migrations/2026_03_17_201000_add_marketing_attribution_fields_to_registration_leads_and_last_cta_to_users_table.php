<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('acquisition_last_cta')->nullable()->after('acquisition_variant');
        });

        Schema::table('registration_leads', function (Blueprint $table) {
            $table->string('utm_source')->nullable()->after('source_detail');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
            $table->string('utm_content')->nullable()->after('utm_campaign');
            $table->string('utm_term')->nullable()->after('utm_content');
            $table->text('acquisition_referrer')->nullable()->after('utm_term');
            $table->string('acquisition_landing_path')->nullable()->after('acquisition_referrer');
            $table->string('acquisition_source_page')->nullable()->after('acquisition_landing_path');
            $table->string('acquisition_variant')->nullable()->after('acquisition_source_page');
            $table->string('acquisition_last_cta')->nullable()->after('acquisition_variant');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['acquisition_last_cta']);
        });

        Schema::table('registration_leads', function (Blueprint $table) {
            $table->dropColumn([
                'utm_source',
                'utm_medium',
                'utm_campaign',
                'utm_content',
                'utm_term',
                'acquisition_referrer',
                'acquisition_landing_path',
                'acquisition_source_page',
                'acquisition_variant',
                'acquisition_last_cta',
            ]);
        });
    }
};
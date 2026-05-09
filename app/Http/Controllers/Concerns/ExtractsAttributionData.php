<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait ExtractsAttributionData
{
    protected function extractAttributionData(Request $request): array
    {
        return $request->only([
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
    }
}
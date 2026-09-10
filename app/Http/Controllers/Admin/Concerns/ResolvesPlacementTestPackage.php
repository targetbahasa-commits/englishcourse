<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\PlacementTestPackage;
use Illuminate\Http\Request;

trait ResolvesPlacementTestPackage
{
    /**
     * Resolve which package the admin is currently managing: explicit
     * ?package_id= wins, otherwise fall back to the active package, otherwise
     * the first package that exists.
     */
    private function resolvePackage(Request $request): ?PlacementTestPackage
    {
        $packageId = $request->query('package_id');
        if ($packageId) {
            $package = PlacementTestPackage::find($packageId);
            if ($package) {
                return $package;
            }
        }

        return PlacementTestPackage::active()->first() ?? PlacementTestPackage::orderBy('id')->first();
    }
}

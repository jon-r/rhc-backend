<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Workshop;
use App\Models\SiteOptions;
use Illuminate\Support\Facades\Request;

class CoreController
{
    public function index()
    {
        $productMax = Product::max('rhc_ref');
        $workshopMax = Workshop::max('workshop_number');

        // todo product stats

        $settings = SiteOptions::select('id', 'name', 'value')
            ->whereIn('name', [
                'Shared Notes',
            ])
            ->get();

        return successResponse([
            'maxValues' => [
                'rhc' => $productMax,
                'workshop' => $workshopMax,
            ],
            'settings' => $settings,
        ]);
    }

    public function edit(Request $req) {
        return successResponse([
            'endpoint' => 'Core edit',
            'request' => $req->all()
        ]);
    }
}
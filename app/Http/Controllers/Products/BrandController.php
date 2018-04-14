<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    private $listColumns = [
        'id',
        'name',
        'slug',
        'image_id',
        'include_on_list',
    ];

    public function edit(Request $req)
    {
        return successResponse([
            'endpoint' => 'Brand edit',
            'request' => $req->all()
        ]);
    }

    public function list()
    {
        $brands = Brand::select(...$this->listColumns)
            ->whereHas('products', function ($q) {
                $q->where('quantity', '>', 0);
            })
            ->with('image')
            ->withCount(['products' => function ($q) {
                $q->where('quantity', '>', 0);
            }])
            ->orderBy('products_count', 'desc')
            ->get();

        return successResponse([
            'endpoint' => $brands
        ]);
    }
}
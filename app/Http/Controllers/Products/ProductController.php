<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $listRows = [
        'id',
        'rhc_ref',
        'product_name',
        'rhc_status',
        'price',
        'shop_notes',
        'curlew_status'
    ];

    private $rows = [
        'id',
        'rhc_ref',
        'rhc_status',
        'curlew_ref',
        'curlew_status',
        'shop_notes',
        'photos_status',
        'print_status',
        'print_notes',
        'product_name',
        'description',
        'quantity',
        'price',
        'original_price',
        'is_job_lot',
        'is_featured',
        'site_flag',
        'site_icon',
        'site_seo_text',
        'video_link',
    ];


    public function add()
    {
        return successResponse([
            'endpoint' => 'Product Add',
            'id' => $id
        ]);
    }

    public function view($id)
    {
        if (!Product::find($id)) {
            return notFoundResponse();
        }

        $product = Product::select(...$this->rows)
            ->where('id', '=', $id)
            ->with([
                'specs:product_id,name,value,sort_order',
                'categories:id,cat_name',
                'tags',
                'images',
                'related:id,product_name',
            ])->first();

        return successResponse([
            'product' => $product
        ]);
    }

    public function list(Request $req)
    {
        $products = Product::select(...$this->listRows)
            ->selectRaw('length(description) as description_length')
            ->where([
                ['rhc_status', '=', 0],
                ['quantity', '>', 0],
            ])
            ->orWhere([
                ['curlew_status', '=', 0],
                ['quantity', '>', 0],
            ])
            ->withCount([
                'categories',
                'images'
            ])
            ->orderBy('id', 'desc');

        return $this->response($products, $req);
    }


    private function response($products, Request $req)
    {
        // pagination handled frontend be default, most queries will be below 100 items
        $items = $products->get();

        return response([
            'status' => 'success',
            'values' => [
                'req' => $req->all(),
                'items' => $items,
            ]
        ]);
    }

    public function edit(Request $req)
    {
        return successResponse([
            'endpoint' => 'Productsedit',
            'request' => $req->all()
        ]);
    }

    public function delete($id)
    {
// delete existing item
    }
}

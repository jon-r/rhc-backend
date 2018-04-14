<?php

namespace App\Http\Controllers\Products;

use App\Enums\ItemStatus;
use App\Enums\ProductStatus;
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
        'brand_id'
    ];


    public function add(Request $req)
    {
        return successResponse([
            'endpoint' => 'Product Add',
            'id' => $req->all()
        ]);
    }

    public function view($id)
    {
        $product = Product::select(...$this->rows)
            ->where('id', '=', $id)
            ->with([
                'specs:product_id,name,value,sort_order',
                'categories:id,cat_name',
                'tags',
                'images',
                'related:id,product_name',
                'items:product_id,serial_number,purchases_id,status,date_on_site,date_sold,date_workshop_done',
                'sales:invoice',
                'workshop:workshop_number,notes,is_completed',
                'brand'
            ])->first();

        return successResponse([
            'product' => $product
        ]);
    }

    public function list(Request $req)
    {
        $filters = [];
        $orFilters = [];
        $itemFilters = [];

        $select = $this->listRows;
        $with = [
            'categories:id,cat_name',
            // only get first image
            'images' => function ($q) {
                $q->where('sort_order', '=', '0');
            },
            'items:id,product_id,updated_at,status'
        ];
        $updated = 'updated_at';

        $requestType = $req->input('type');
        if ($requestType === 'to go') {
            $filters[] = ['rhc_status', '=', ProductStatus::ToAdd];
            $filters[] = ['quantity', '>', 0];
            $orFilters[] = ['curlew_status', '=', ProductStatus::ToAdd];
            $orFilters[] = ['quantity', '>', 0];
        } else if ($requestType === 'to print') {
            $select = [
                'id',
                'rhc_ref',
                'product_name',
                'print_status',
                'print_notes'
            ];
            $with = [
                'images' => function ($q) {
                    $q->where('sort_order', '=', '0');
                }
            ];
            $filters[] = ['print_status', '<', ProductStatus::ToSkip];
            $filters[] = ['quantity', '>', 0];
        } else if ($requestType === 'to price') {
            $filters[] = ['quantity', '>', 0];
            $filters[] = ['price', '=', 0];
        } else if ($requestType === 'on site') {
            $updated = 'date_on_site';
            $filters[] = ['rhc_status', '=', ProductStatus::Added];
            $filters[] = ['quantity', '>', 0];
            $orFilters[] = ['curlew_status', '=', ProductStatus::Added];
            $orFilters[] = ['quantity', '>', 0];
        }

        $days = $req->input('days-since-update');
        if ($days !== null) {
            $date = date_create();
            $dateFrom = date_sub($date, date_interval_create_from_date_string("$days days"));

            $itemFilters[] = [$updated, '<', $dateFrom->format('Y-m-d\TH:i:s')];
        }

        $products = Product::select(...$select)
            ->where($filters)
            ->whereHas('items', function ($q) use ($itemFilters) {
                $q->where($itemFilters);
            })
            ->with($with)
            ->get();

        return successResponse([
            'req' => $req->all(),
            'count' => count($products),
            'products' => $products,
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

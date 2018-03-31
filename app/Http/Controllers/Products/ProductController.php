<?php
namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  private $columns = [
    'id',
    'rhc_ref',
    'rhc_status',
    'curlew_ref',
    'curlew_status',
    'shop_notes',
    'photos_status',
    'print_status',
    'print_notes',
    'invoice',
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
    'date_live',
    'date_sold',
    'video_link',
  ];

  public function new() {
// add new item
  }

  public function store() {
// save new item
  }

  public function show($id) {
    if (!Product::find($id)) {
        return notFoundResponse();
    }

    $product = Product::select(...$this->columns)
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

  public function edit($id) {
// update existing item
  }

  public function delete($id) {
// delete existing item
  }
}

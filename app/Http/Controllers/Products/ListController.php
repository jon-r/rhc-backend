<?php

namespace App\Http\Controllers\Products;
use App\Models\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListController extends Controller
{
  private $values = ['id','rhc_ref','product_name','rhc_status','price','shop_notes','curlew_status'];

  public function toGoOnline(Request $req) {
    $products = Product::select(...$this->values)
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

  private function response($products, Request $req) {
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
}

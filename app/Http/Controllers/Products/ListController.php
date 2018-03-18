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
    ->where([
      ['rhc_status', '=', 0],
      ['quantity', '>', 0],
    ])
    ->orWhere([
      ['curlew_status', '=', 0],
      ['quantity', '>', 0],
    ])
    ->orderBy('id', 'desc');

    return $this->response($products, $req);
  }

  private function response($products, Request $req) {
    $count = $products->count();

    $items = $products
    ->limit(20)
    ->offset(($req->query('page', 1) - 1) * 20)
    ->get();

    return response([
      'status' => 'success',
      'values' => [
        // 'req' => $req->all(), 
        'count' => $count,
        'items' => $items,
      ]
    ]);
  }
}

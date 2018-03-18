<?php

namespace App\Http\Controllers\Products;
use App\Models\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{

  // /**
  //  * Create a new controller instance.
  //  *
  //  * @return void
  //  */
  // public function __construct()
  // {
  //     //
  // }

  public function new() {

  }

  public function store() {

  }

  public function edit($id) {

  }

  public function show($id) {

  }

  private $listValues = ['id','rhc_ref','product_name','rhc_status','price','shop_notes','curlew_status'];

  private function listAll() {
    return Product::select(...$this->listValues);
  }

  private function listToGoOnline() {
    return Product::select(...$this->listValues)
    ->where([
      ['rhc_status', '=', 0],
      ['quantity', '>', 0],
    ])
    ->orWhere([
      ['curlew_status', '=', 0],
      ['quantity', '>', 0],
    ]);
  }

  public function list(Request $req, $common = false) {
    switch ($common) {
      case 'toGoOnline':
        $selected = $this->listToGoOnline();
        break;
      default:
        $selected = $this->listAll();
    };

    $count = $selected->count();

    $products = $selected->orderBy('id', 'desc')
    ->limit(20)
    ->offset(($req->query('page', 1) - 1) * 20)
    ->get();

    return response([
      'status' => 'success',
      'values' => [
        'req' => $req->all(), // todo remove this. for debug only
        'count' => $count,
        'items' => $products,
      ]
    ]);
  }

  public function listCategory(Request $req) {

  }

  public function delete($id) {

  }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AppLayoutController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function getAppLayout() {
    return [
      'navigation' => $this->getMenus('app/%')
    ];
  }

  public function setMenus($values) {
    return $values;
  }

  private function getMenus($location) {
    return DB::table('site_navigation')
    ->select('name','location','value')
    ->where('location', 'like', $Location)
    ->get();
  }

  // depreciated

  /* maybe load on init based on urls? eg homepage links. */
  public function getAppInit() {
    return [
      'content' => $this->getSiteContent(),
      'navigation' => $this->getSiteNavigation(),
    ];
  }

  private function getSiteNavigation() {
    return DB::table('site_navigation')
    ->select('name','url','location','image_link')
    ->where('load_on_init', true)
    ->orderBy('sort_order','asc')
    ->get();
  }

  private function getSiteContent() {
    return DB::table('site_content')
    ->select('name','location','value')
    ->where('load_on_init', true)
    ->get();
  }


}

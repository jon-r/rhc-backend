<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SiteNavController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index() {
    $navBars = [
      'rightMenu' => $this->getNavBar('rightMenu')
    ];

    return view('admin.site_nav', ['navBars' => $navBars]);

  }

  private function getNavBar($location) {
    return DB::table('site_navigation')
    ->select('*')
    ->where('location', '=',"navbar/{$location}")
    ->orderBy('sort_order','asc')
    ->get();
  }
}

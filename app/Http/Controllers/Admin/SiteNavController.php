<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings\Navigation;
use Illuminate\Support\Facades\DB;

class SiteNavController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function edit($location) {
    $links = Navigation::where('location', "navbar/$location")->orderBy('sort_order','asc')->get();

    return view('admin.appNavigationEditor', compact('links', 'location'));
  }

  public function save() {

  }
}

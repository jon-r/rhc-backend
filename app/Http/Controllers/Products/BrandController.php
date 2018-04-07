<?php


// use App\Models\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function add()
    {
        return successResponse([
            'endpoint' => 'Brand Add'
        ]);
    }

    public function view($id)
    {
        return successResponse([
            'endpoint' => 'Brand View ',
            'id' => $id
        ]);
    }

    public function edit(Request $req)
    {
        return successResponse([
            'endpoint' => 'Brand edit',
            'request' => $req->all()
        ]);
    }

    public function list(Request $req)
    {
        return successResponse([
            'endpoint' => 'Brand list',
            'request' => $req->all()
        ]);
    }
}
<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class ProductController
{
    public function view($id)
    {
        return successResponse([
            'result' => 'frontend view',
            'id' => $id
        ]);
    }

    public function list(Request $req)
    {
        return successResponse([
            'endpoint' => 'product list',
            'request' => $req->all()
        ]);
    }

    public function search(Request $req)
    {
        return successResponse([
            'endpoint' => 'product search',
            'request' => $req->all()
        ]);
    }
}
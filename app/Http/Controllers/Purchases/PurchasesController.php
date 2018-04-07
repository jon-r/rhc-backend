<?php

namespace App\Http\Controllers\Purchases;

// use App\Models\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function add(Request $req)
    {
        return successResponse([
            'endpoint' => 'Purchase Add',
            'request' => $req->all()
        ]);
    }

    public function view($id)
    {
        return successResponse([
            'endpoint' => 'Purchase View ',
            'id' => $id
        ]);
    }

    public function edit(Request $req)
    {
        return successResponse([
            'endpoint' => 'Purchase edit',
            'request' => $req->all()
        ]);
    }

    public function list(Request $req)
    {
        return successResponse([
            'endpoint' => 'Purchase list',
            'request' => $req->all()
        ]);
    }
}
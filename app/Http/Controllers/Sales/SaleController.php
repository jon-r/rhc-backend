<?php

namespace App\Http\Controllers\Sales;

// use App\Models\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function add()
    {
        return successResponse([
            'endpoint' => 'Sale Add'
        ]);
    }

    public function view($id)
    {
        return successResponse([
            'endpoint' => 'Sale View ',
            'id' => $id
        ]);
    }

    public function edit(Request $req)
    {
        return successResponse([
            'endpoint' => 'Sale edit',
            'request' => $req->all()
        ]);
    }

    public function list(Request $req)
    {
        return successResponse([
            'endpoint' => 'Sale list',
            'request' => $req->all()
        ]);
    }
}
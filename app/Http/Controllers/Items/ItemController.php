<?php

namespace App\Http\Controllers\Items;

// use App\Models\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function add(Request $req)
    {
        return successResponse([
            'endpoint' => 'Item Add',
            'request' => $req->all()
        ]);
    }

    public function view($id)
    {
        return successResponse([
            'endpoint' => 'Item View ',
            'id' => $id
        ]);
    }

    public function list(Request $req)
    {
        return successResponse([
            'endpoint' => 'Item list',
            'request' => $req->all()
        ]);
    }
}
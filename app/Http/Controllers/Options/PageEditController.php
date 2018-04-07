<?php

namespace App\Http\Controllers\Options;

// use App\Models\Option;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageEditController extends Controller
{
    public function add()
    {
        return successResponse([
            'endpoint' => 'Option Add'
        ]);
    }

    public function view($id)
    {
        return successResponse([
            'endpoint' => 'Option View ',
            'id' => $id
        ]);
    }

    public function edit(Request $req)
    {
        return successResponse([
            'endpoint' => 'Option edit',
            'request' => $req->all()
        ]);
    }

    public function list(Request $req)
    {
        return successResponse([
            'endpoint' => 'Option list',
            'request' => $req->all()
        ]);
    }
}
<?php

namespace App\Http\Controllers\Workshop;

// use App\Models\Workshop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{

    public function view($id)
    {
        return successResponse([
            'endpoint' => 'Workshop View ',
            'id' => $id
        ]);
    }

    public function edit(Request $req)
    {
        return successResponse([
            'endpoint' => 'Workshop edit',
            'request' => $req->all()
        ]);
    }

    public function list(Request $req)
    {
        return successResponse([
            'endpoint' => 'Workshop list',
            'request' => $req->all()
        ]);
    }
}
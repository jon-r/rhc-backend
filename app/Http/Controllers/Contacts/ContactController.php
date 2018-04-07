<?php

namespace App\Http\Controllers\Contacts;

// use App\Models\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function add()
    {
        return successResponse([
            'endpoint' => 'Contact Add'
        ]);
    }

    public function view($id)
    {
        return successResponse([
            'endpoint' => 'Contact View ',
            'id' => $id
        ]);
    }

    public function edit(Request $req)
    {
        return successResponse([
            'endpoint' => 'Contact edit',
            'request' => $req->all()
        ]);
    }

    public function list(Request $req)
    {
        return successResponse([
            'endpoint' => 'Contact list',
            'request' => $req->all()
        ]);
    }
}
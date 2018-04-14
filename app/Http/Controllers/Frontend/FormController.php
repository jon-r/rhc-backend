<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Request;

class FormController
{
    public function submit(Request $req) {
        return successResponse([
            'result' => 'message submit',
            'request' => $req->all()
        ]);
    }
}
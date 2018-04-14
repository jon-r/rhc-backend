<?php

namespace App\Http\Controllers\Frontend;


class ListController
{
    public function categories()
    {
        return successResponse([
            'endpoint' => 'categories list'
        ]);
    }

    public function brands()
    {
        return successResponse([
            'endpoint' => 'brands list'
        ]);
    }
}
<?php

namespace App\Http\Controllers\Options;


class SiteImagesController
{
    public function list() {
        return successResponse([
            'endpoint' => 'image list'
        ]);
    }
}
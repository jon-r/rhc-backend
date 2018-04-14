<?php

namespace App\Http\Controllers\Frontend;


class CoreController
{
    public function siteLoad() {
        return successResponse([
            'result' => 'frontend core'
        ]);
    }

    public function common() {
        return successResponse([
            'result' => 'frontend common'
        ]);
    }
}
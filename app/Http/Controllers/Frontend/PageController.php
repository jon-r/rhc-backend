<?php

namespace App\Http\Controllers\Frontend;

class PageController
{
    public function viewPage($id) {
        return successResponse([
            'result' => 'page view',
            'id' => $id
        ]);
    }

    public function homePage() {
        return successResponse([
            'result' => 'home page view'
        ]);
    }

    public function contactPage() {
        return successResponse([
            'result' => 'contact page view'
        ]);
    }

}
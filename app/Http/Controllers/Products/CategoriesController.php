<?php
namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Models\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $columns = [
        'id',
        'cat_name',
        'slug',
        'sort_order',
        'description',
        'image_link',
    ];

    private $groupColumns = [
        'id',
        'group_name',
        'sort_order',
        'sort_order',
        'description',
        'image_link',
    ];

    public function show() {
        $groups = Group::select(...$this->groupColumns)
            ->with('categories')
            ->orderBy('sort_order', 'asc')
            ->get();

        return successResponse([
            'groups' => $groups
        ]);
    }
}
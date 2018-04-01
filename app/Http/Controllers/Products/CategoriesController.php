<?php
namespace App\Http\Controllers\Products;

use App\Models\Category;
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
        'group_id',
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
            ->orderBy('sort_order', 'asc')
            ->get();

        $categories = Category::select(...$this->columns)
            ->orderBy('sort_order', 'asc')
            ->get();

        return successResponse([
            'groups' => $groups,
            'categories' => $categories,
        ]);
    }

    public function names() {
        $categories = Category::select('cat_name', 'id')
            ->orderBy('sort_order', 'asc')
            ->get();

        return successResponse([
            'categories' => $categories,
        ]);
    }

    public function update(Request $req) {
        $category = Category::find($req->id);

        if (!$category) {
            return notFoundResponse();
        }

        $category->update([
            'cat_name' => $req->cat_name,
            'slug' => $req->slug,
            'sort_order' => $req->sort_order,
            'group_id' => $req->group_id,
            'description' => $req->description,
            'image_link' => $req->image_link,
        ]);

        return successResponse([
            'category' => $category
        ], 'Category Updated');
    }
}

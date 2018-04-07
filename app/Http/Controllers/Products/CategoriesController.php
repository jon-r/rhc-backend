<?php

namespace App\Http\Controllers\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    private $columns = [
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

    public function list()
    {
        $groups = Group::select(...$this->groupColumns)
            ->orderBy('sort_order', 'asc')
            ->get();

        $categories = Category::select('id', ...$this->columns)
            ->orderBy('sort_order', 'asc')
            ->get();

        return successResponse([
            'groups' => $groups,
            'categories' => $categories,
        ]);
    }

    // todo move this to a CMS load request?
//    public function names()
//    {
//        $categories = Category::select('cat_name', 'id')
//            ->orderBy('sort_order', 'asc')
//            ->get();
//
//        return successResponse([
//            'categories' => $categories,
//        ]);
//    }

//    public function edit(Request $req)
//    {
//        $category = Category::find($req->id);
//
//        if (!$category) {
//            return notFoundResponse();
//        }
//
//        $category->update([
//            'cat_name' => $req->cat_name,
//            'slug' => $req->slug,
//            'sort_order' => $req->sort_order,
//            'group_id' => $req->group_id,
//            'description' => $req->description,
//            'image_link' => $req->image_link,
//        ]);
//
//        return successResponse([
//            'category' => $category
//        ], 'Category Updated');
//    }

    public function edit(Request $req)
    {
        $ids = [];

        foreach ($req->input('categories') as $index => $category) {

            $ids[] = $category['id'];

            Category::updateOrCreate(
                [
                    'id' => $category['id']
                ],
                [
                    'cat_name' => $category['cat_name'],
                    'slug' => $category['slug'],
                    'description' => $category['description'],
                    'image_link' => $category['image_link'],
                    'sort_order' => $index,
                    'group_id' => $req->input('group'),
                ]
            );
        }

        $cats = DB::table('rhc_categories')->whereIn('id', $ids)->get();

        return successResponse([
            'categories' => $cats,
        ], 'Categories have been updated');
    }
}

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
        'id',
        'cat_name',
        'slug',
        'sort_order',
        'group_id',
        'description',
        'image_id'
    ];

    private $groupColumns = [
        'id',
        'group_name',
        'sort_order',
        'sort_order',
        'description',
        'image_id'
    ];

    public function list()
    {
        $groups = Group::select(...$this->groupColumns)
            ->with('image')
            ->orderBy('sort_order', 'asc')
            ->get();

        $categories = Category::select(...$this->columns)
            ->with('image')
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

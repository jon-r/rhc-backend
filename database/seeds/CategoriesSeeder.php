<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = DB::table('old_rhc_categories')
            ->select('CategoryGroup')->distinct()
            ->where('CategoryGroup', '<>', '')
            ->get();

        $inserted = [];
        foreach ($groups as $i => $group) {
            $inserted[] =['group_name' => $group->CategoryGroup];
        }
        DB::table('rhc_groups')->insert($inserted);

        $categories = DB::table('old_rhc_categories')
            ->where('Category_ID', '>', 0)
            ->join('rhc_groups', 'old_rhc_categories.CategoryGroup', '=', 'rhc_groups.group_name')
            ->get();

        $inserted = [];
        foreach ($categories as $k => $c) {
            $inserted[] = [
                'cat_name' => $c->Name,
                'slug' => $this->slugify($c->Name),
                'sort_order' => $c->List_Order,
                'group_id' => $c->id,
                'description' => $c->CategoryDescription,
            ];
        }
        DB::table('rhc_categories')->insert($inserted);

        $this->insertCategoryXrefs();
    }

    private function slugify($title)
    {
        return preg_replace('/[^\w]+/', '-', strtolower($title));
    }

    private function insertCategoryXrefs()
    {
        $inserted = [];
        $categories = ['Category', 'Cat1', 'Cat2', 'Cat3'];
        foreach ($categories as $cat) {
            $products = DB::table('old_networked')
                ->join('rhc_products', 'rhc_products.rhc_ref', '=', 'old_networked.RHC')
                ->join('rhc_categories', 'rhc_categories.cat_name', '=', "old_networked.$cat")
                ->select('rhc_products.id as product_id', 'rhc_categories.id as category_id')
                ->get();

            foreach ($products as $key => $row) {
                $inserted[] = [
                    'product_id' => $row->product_id,
                    'category_id' => $row->category_id,
                ];
            }
        }
        DB::table('rhc_categories_xrefs')->insert($inserted);
    }
}

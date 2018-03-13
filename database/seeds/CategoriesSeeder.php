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

    foreach ($groups as $i => $group) {
      DB::table('rhc_groups')->insert([
        'group_name' => $group->CategoryGroup,
      ]);
    }

    $categories = DB::table('old_rhc_categories')
    ->where('Category_ID' , '>', 0)
    ->join('rhc_groups', 'old_rhc_categories.CategoryGroup', '=', 'rhc_groups.group_name')
    ->get();

    foreach ($categories as $k => $c) {
      DB::table('rhc_categories')->insert([
        'cat_name' => $c->Name,
        'slug' => $this->slugify($c->Name),
        'sort_order' => $c->List_Order,
        'cat_group' => $c->id,
        'description' => $c->CategoryDescription,
      ]);
    }
  }

  private function slugify($title) {
    return preg_replace('/[^\w]+/','-', strtolower($title));
  }
}

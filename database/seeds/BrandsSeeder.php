<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = DB::table('old_networked')
            ->select('Brand')->distinct()
            ->where([
                ['Brand', '<>', '0'],
                ['Brand', '<>', ''],
            ])
            ->get();

        $inserted = [];

        foreach ($brands as $k => $b) {
            $inserted[] = [
                'name' => $b->Brand,
                'slug' => $this->slugify($b->Brand)
            ];
        }

        DB::table('rhc_brands')->insert($inserted);
    }

    private function slugify($title)
    {
        return preg_replace('/[^\w]+/', '-', strtolower($title));
    }
}

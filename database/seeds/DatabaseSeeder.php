<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('BrandsSeeder');
        $this->call('ProductsSeeder');
        $this->call('CategoriesSeeder');
        $this->call('SpecSeeder');
        $this->call('WorkshopSeeder');
        $this->call('SalesSeeder');
        $this->call('ItemSeeder');
    }
}

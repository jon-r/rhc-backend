<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteNavigationSeeder extends Seeder
{
      use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->disableForeignKeys();
      $this->truncate('site_navigation');

      $links = [
          [
            'name' => 'Home',
            'url' => '/',
            'location' => 'navbar/rightMenu',
            'sort_order' => '0',
            'load_on_init' => true
          ],
          [
            'name' => 'Catering Equipment',
            'url' => '/store',
            'location' => 'navbar/rightMenu',
            'sort_order' => '1',
            'load_on_init' => true
          ],
      ];

      DB::table('site_navigation')->insert($links);

      $this->enableForeignKeys();
    }
}

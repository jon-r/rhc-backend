<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteContentSeeder extends Seeder
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
       $this->truncate('site_content');

       $values = [
           [
             'name' => 'Header Contact Text',
             'location' => 'header/contact',
             'value' => '${icon=tel} 01925 242 623<br />
             ${icon=email} info@redhotchilli.catering',
             'load_on_init' => true
           ],
       ];

       DB::table('site_content')->insert($values);

       $this->enableForeignKeys();
     }
}

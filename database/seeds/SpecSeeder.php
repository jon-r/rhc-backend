<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $specs = $this->selectSpec('Brand', 0)
    ->union($this->selectSpec('Model', 1))
    ->union($this->selectSpec('Height', 2))
    ->union($this->selectSpec('Width', 3))
    ->union($this->selectSpec('Depth', 4))
    ->get();

    foreach ($specs as $k => $s) {
      DB::table('rhc_specs')->insert([
        'product_id' => $s->product_id,
        'name' => $s->name,
        'value' => $s->value,
        'sort_order' => $s->sort_order,
      ]);
    }

    $power = $this->selectPower()->get();
    foreach ($power as $k => $values) {
      DB::table('rhc_specs')->insert(
        $this->joinPower($values)
      );
    }

    $extras = $this->selectExtras()->get();

    foreach ($extras as $k => $values) {
      DB::table('rhc_specs')->insert(
        $this->splitExtras($values)
      );
    }
  }

  private function selectSpec($name, $sort) {
    return DB::table('networked db')
    ->where([
      [$name, '<>', '0'],
      [$name, '<>', ''],
      [$name, '<>', 0],
    ])
    ->join('rhc_products', 'rhc_products.rhc_ref', '=', 'networked db.RHC')
    ->select(
      'rhc_products.id as product_id',
      "networked db.$name as value",
      DB::raw("'$name' as name, $sort as sort_order")
    );
  }

  private function selectPower() {
    $power = 'networked db.Power';
    $wattage = 'networked db.Wattage';

    return DB::table('networked db')
    ->where($power, '<>', '0')
    ->orwhere($wattage, '>', 0)
    ->join('rhc_products', 'rhc_products.rhc_ref', '=', 'networked db.RHC')
    ->select(
      'rhc_products.id as product_id',
      "$power as power",
      "$wattage as watts"
    );
  }

  private function joinPower($row) {
    // todo fix power;
    // $arr = [];
    $offset = 5;


    if ($row->watts > 1500) {
      $watts = ($row->watts / 1000).'kw';
    } elseif ($row->watts > 0) {
      $watts = ($row->watts).' watts';
    } else {
      $watts = false;
    }
    if ($row->power !== '0') {
      $type = $row->power;
    } else {
      $type = false;
    };

    $arr[] = [
      'product_id' => $row->product_id,
      'name' => 'Power',
      'value' => implode(', ', [$watts, $type]),
      'sort_order' => $offset,
    ];

    return $arr;
  }

  private function selectExtras() {
    $extras = 'networked db.ExtraMeasurements';

    return DB::table('networked db')
    ->where([
      [$extras, '<>', '0'],
      [$extras, '<>', ''],
    ])
    ->join('rhc_products', 'rhc_products.rhc_ref', '=', 'networked db.RHC')
    ->select(
      'rhc_products.id as product_id',
      "$extras as value_list"
    );
  }

  private function splitExtras($row) {
    $offset = 6;
    $values = explode(';', $row->value_list);

    foreach ($values as $i => $line) {
      $pairs = explode(':', $line);

      $arr[] = [
        'product_id' => $row->product_id,
        'name' => $pairs[0],
        'value' => count($pairs) > 1 ? $pairs[1] : '',
        'sort_order' => $offset + $i,
      ];
    }

    return $arr;
  }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
      $products = DB::table('networked db')->get();

      // DB::table('rhc_products')->delete();

      foreach ($products as $k => $p) {
        DB::table('rhc_products')->insert([
          'rhc_ref' => $p->RHC,
          'rhc_status' => $p->LiveonRHC,
          'curlew_ref' => $p->CurlewRef,
          'curlew_status' => $this->getStatusFrom(
            $p->LiveonCurlew,
            $p->NotForCurlew
          ),
          'shop_notes' => $p->ExtraComments,
          'photos_status' => $this->getStatusFrom(
            $p->HasPics
          ),
          'print_status' => $this->getStatusFrom(
            $p->PrintAttached,
            $p->HasPrinted,
            $p->SkipPrint
          ),
          'print_notes' => $p->PrintSize,
          'invoice' => $p->InvoiceNumber,
          'product_name' => $p->ProductName,
          'description' => $this->getDescription(
            $p->{'Line 1'},
            $p->{'Line 2'},
            $p->{'Line 3'},
            $p->{'Condition/Damages'}
          ),
          'quantity' => $p->Quantity,
          'price' => $p->Price,
          'site_icon' => $this->getIcon(
            $p->Power,
            $p->Category,
            $p->Cat1,
            $p->Cat2,
            $p->Cat3
          ),
          'site_seo_text' => $p->SEO_meta_text,
          'date_live' => $p->DateLive  !== '0000-00-00 00:00:00' ? $p->DateLive : null,
          'date_sold' => $p->DateSold !== '0000-00-00 00:00:00' ? $p->DateSold : null,
          'video_link' => $p->video_link
        ]);
      }
  }

  private function getStatusFrom($optionDefault, ...$optionsArr) {
    $i = count($optionsArr);
    while ($i) {
      if ($optionsArr[$i - 1]) return $i;
      $i--;
    }
    return $optionDefault;
  }

  private function getDescription($line1, ...$lines) {
    $out = $line1;
    foreach ($lines as $line) {
      $out .= $line !== '0' ? "\r\r$line" : '';
    }
    return $out;
  }

  private function getIcon($power, ...$categories) {
    $catStr = implode('',$categories);
    $hasFridge = strpos($catStr, 'Fridge');
    $hasFreezer = strpos($catStr, 'Freezer');
    if ($hasFridge && $hasFreezer) return 1;
    if ($hasFridge) return 2;
    if ($hasFreezer) return 3;

    switch ($power) {
      case 'Single Phase' : return 4;
      case 'Three Phase' : return 5;
      case 'Natural Gas' : return 6;
      case 'LPG' : return 7;
      case 'Dual Fuel' : return 8;
      default: return 0;
    }
  }
}

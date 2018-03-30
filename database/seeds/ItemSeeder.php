<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

abstract class ItemStatus
{
    const NewItem = 0;
    const InWorkshop = 1;
    const RHCToGo = 2;
    const LiveOnRHC = 3;
    const IsSold = 4;
    const IsScrapped = 5;
}

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workshop = DB::table('old_workshop_work')
            ->where('product_ref', '>', 0)
            ->join('workshop', 'workshop.workshop_number', '=', 'old_workshop_work.product_ref')
            ->get();

        $products = DB::table('old_networked')
            ->join('rhc_products', 'rhc_products.rhc_ref', '=', 'old_networked.RHC')
            ->get();

        $sales = DB::table('old_networked')
            ->join('sales', 'sales.invoice', '=', 'old_networked.InvoiceNumber')
            ->get();

        $items = [];

        // workshop MUST be first. many workshop = one product
        foreach ($workshop as $k => $w) {
            $pKey = array_search($w->RHC, array_column($products, 'rhc_ref'));
            $p = $pKey ? $products[$pKey] : null;

            $sKey = array_search($w->RHC, array_column($sales, 'rhc_ref'));
            $s = $sKey ? $sales[$sKey] : null;

            $status = $this->getWorkshopStatus($w, $p);

            $items[] = [
                'name' => $w->Item,
                'status' => $status,
                'serial_number' => $this->getIfExists($w->SerialNumber, $p->SerialNo),
                'workshop_id' => $w->id,
                'workshop_in' => $w->Date_In,
                'workshop_out' => $w->Date_Out,
                'product_id' => $this->getIfExists($p->id),
                'date_live' => $this->getIfExists($p->DateLive),
                'date_sold' => $this->getSoldDate($status, $p->DateSold, $w->Date_Out),
                'sales_id' => $this->getIfExists($s->id),
                'date_scrapped' => $this->getScrappedDate($status, $w->Date_Out),
            ];
        }

        foreach ($products as $k => $p) {
            if (!array_search($p->id, array_column($items, 'product_id'))) {
                // todo add sales here
                $sKey = array_search($p->rhc_ref, array_column($sales, 'rhc_ref'));
                $s = $sKey ? $sales[$sKey] : null;

                $status = $this->getRHCStatus($p);

                $items[] = [
                    'name' => $p->ProductName,
                    'status' => $status,
                    'serial_number' => $this->getIfExists($p->SerialNo),
                    'product_id' => $p->id,
                    'date_live' => $p->DateLive,
                    'date_sold' => $this->getSoldDate($status, $p->DateSold),
                    'sales_id' => $this->getIfExists($s->id)
                ];
            }
        }

        DB::table('items')->insert($items);
    }

    private function getWorkshopStatus($w, $p)
    {
        if ($w->Scrap) {
            return ItemStatus::IsScrapped;
        } elseif ($w->Sold || $p && $p->Quantity === 0) {
            return ItemStatus::IsSold;
        } elseif ($p && $p->LiveonRHC) {
            return ItemStatus::LiveOnRHC;
        } elseif ($w->IsCompleted) {
            return ItemStatus::RHCToGo;
        } else {
            return ItemStatus::InWorkshop;
        }
    }

    private function getRHCStatus($p) {
        if ($p->Quantity === 0) {
            return ItemStatus::IsSold;
        } elseif ($p && $p->LiveonRHC) {
            return ItemStatus::LiveOnRHC;
        } else {
            return ItemStatus::RHCToGo;
        }
    }

    private function getIfExists(...$values)
    {
        $out = null;

        foreach ($values as $value) {
            if ($value && $value !== '0') {
                $out = $value;
                break;
            }
        }

        return $out;
    }

    private function getSoldDate($status, ... $dates)
    {
        $newest = 0;

        if ($status === ItemStatus::IsSold) {
            foreach ($dates as $date) {
                if ($date && strtotime($date) > $newest) {
                    $newest = $date;
                }
            }
        }

        return $newest ?? null;
    }

    private function getScrappedDate($status, $date) {
        if ($status === ItemStatus::IsScrapped) {
            return $date;
        } else {
            return null;
        }
    }
}


/* ROWS
id
created_at
updated_at
name
status
serial_number
purchases_id
purchased_date
workshop_id
workshop_in
workshop_out
product_id
date_live
date_sold
sales_id
date_scrapped


*/
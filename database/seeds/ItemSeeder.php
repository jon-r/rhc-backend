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
    public function minDate() {
        return strtotime('2010-01-01');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workshop = DB::table('old_workshop_db')
            ->where('product_ref', '>', 0)
            ->join('workshop', 'workshop.workshop_number', '=', 'old_workshop_db.product_ref')
            ->get();

        $products = DB::table('old_networked')
            ->join('rhc_products', 'rhc_products.rhc_ref', '=', 'old_networked.RHC')
            ->get();

        $sales = DB::table('old_networked')
            ->join('sales', 'sales.invoice', '=', 'old_networked.InvoiceNumber')
            ->get();

        $fromWorkshop = [];

        // workshop MUST be first. many workshop = one product
        foreach ($workshop as $k => $w) {
            $p = $this->findInObject('RHC',$w->RHC, $products);
            $s = $this->findInObject('RHC',$w->RHC, $sales);

            $status = $this->getWorkshopStatus($w, $p);

            $fromWorkshop[] = [
                'name' => $w->Item,
                'status' => $status,
                'serial_number' => $this->getSerial($w, $p),
                'workshop_id' => $w->id,
                'workshop_in' => strtotime($w->Date_In) > $this->minDate() ? $w->Date_In : null,
                'workshop_out' => strtotime($w->Date_Out) > $this->minDate() ? $w->Date_Out : null,
                'product_id' => $this->valueExists($p, 'id') ?: null,
                'date_live' => $this->valueExists($p, 'DateLive') && strtotime($p->DateLive) > $this->minDate() ? $p->DateLive : null,
                'date_sold' => $p ? $this->getSoldDate($status, $w, $p) : null,
                'sales_id' => $this->valueExists($s, 'id') ?: null,
                'date_scrapped' => $this->getScrappedDate($status, $w->Date_Out),
            ];
        }

        DB::table('items')->insert($fromWorkshop);
        $items = DB::table('items')->get();

        $fromProducts = [];

        foreach ($products as $k => $p) {
            if (!$this->findInObject('product_id',$p->id, $items)) {
                $s = $this->findInObject('RHC',$p->RHC, $sales);

                $status = $this->getRHCStatus($p);

                $fromProducts[] = [
                    'name' => $p->ProductName,
                    'status' => $status,
                    'serial_number' => $this->valueExists($p,'SerialNo') ?: '',
                    'product_id' => $p->id,
                    'date_live' => strtotime($p->DateLive) > $this->minDate() ? $p->DateLive : null,
                    'date_sold' => $this->getSoldDate($status, null, $p),
                    'sales_id' => $this->valueExists($s,'id') ?: null
                ];
            }
        }

        DB::table('items')->insert($fromProducts);
    }

    private function findInObject($key,$value,$object) {
        $item = null;
        foreach($object as $row) {
            if ($value > 0 && $row->$key === $value) {
                $item = $row;
                break;
            }
        }
        return $item;
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


    private function getSerial($w, $p) {
        return $this->valueExists($w, 'SerialNumber') ?: $this->valueExists($p, 'SerialNo') ?: '';
    }

    private function valueExists($obj, $key) {
        return $obj && $obj->$key && $obj->$key !== '0' ? $obj->$key : false;
    }

    private function getSoldDate($status, $w, $p)
    {
        $date = null;

        if ($status === ItemStatus::IsSold) {
            $date = $this->valueExists($p, 'DateSold') ?: $this->valueExists($w, 'Date_out');
        }

        return ( $date && strtotime($date) > $this->minDate()) ? $date : null;
    }

    private function getScrappedDate($status, $date) {
        if ($status === ItemStatus::IsScrapped && strtotime($date)  > $this->minDate()) {
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
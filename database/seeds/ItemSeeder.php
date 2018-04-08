<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ItemStatus;

class ItemSeeder extends Seeder
{
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
            $p = $this->findInObject('RHC', $w->RHC, $products);
            $s = $this->findInObject('RHC', $w->RHC, $sales);

            $status = $this->getWorkshopStatus($w, $p);

            $fromWorkshop[] = [
                'name' => $w->Item,
                'created_at' => $this->dateIfValid($w->Date_In),
                'status' => $status,
                'serial_number' => $this->getSerial($w, $p),
                'workshop_id' => $w->id,
                'date_workshop_done' => $this->dateIfValid($w->Date_Out),
                'product_id' => $this->valueExists($p, 'id'),
                'date_on_site' => $this->valueExists($p, 'DateLive') ? $this->dateIfValid($p->DateLive) : null,
                'date_sold' => $p ? $this->getSoldDate($status, $w, $p) : null,
                'sales_id' => $this->valueExists($s, 'id'),
            ];
        }

        $fromProducts = [];

        foreach ($products as $k => $p) {
            if (!array_search(
                $p->id,
                array_column($fromWorkshop, 'product_id')
            )) {
                $s = $this->findInObject('RHC', $p->RHC, $sales);

                $status = $this->getRHCStatus($p);

                $fromProducts[] = [
                    'name' => $p->ProductName,
                    // no date in available, assume 1 week before date live
                    'created_at' => $this->dateIfValid($p->DateLive, '1 week'),
                    'status' => $status,
                    'serial_number' => $this->valueExists($p, 'SerialNo') ?: '',
                    'workshop_id' => null,
                    'date_workshop_done' => null,
                    'product_id' => $p->id,
                    'date_on_site' => $this->dateIfValid($p->DateLive),
                    'date_sold' => $this->getSoldDate($status, null, $p),
                    'sales_id' => $this->valueExists($s, 'id'),
                ];
            }
        }

        $merged = array_merge($fromWorkshop, $fromProducts);

        usort($merged, function ($a, $b) {
            return ($a['workshop_id'] ?: 0) - ($b['workshop_id'] ?: 0);
        });
        usort($merged, function ($a, $b) {
            return ($a['product_id'] ?: 0) - ($b['product_id'] ?: 0);
        });

        DB::table('items')->insert($merged);
    }

    private function findInObject($key, $value, $object)
    {
        $item = null;
        foreach ($object as $row) {
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

    private function getRHCStatus($p)
    {
        if ($p->Quantity === 0) {
            return ItemStatus::IsSold;
        } elseif ($p && $p->LiveonRHC) {
            return ItemStatus::LiveOnRHC;
        } else {
            return ItemStatus::RHCToGo;
        }
    }


    private function getSerial($w, $p)
    {
        return $this->valueExists($w, 'SerialNumber') ?: $this->valueExists($p, 'SerialNo') ?: '';
    }

    private function valueExists($obj, $key)
    {
        return $obj && $obj->$key && $obj->$key !== '0' ? $obj->$key : null;
    }

    private function getSoldDate($status, $w, $p)
    {
        $date = null;

        if ($status === ItemStatus::IsSold) {
            $date = $this->valueExists($p, 'DateSold') ?: $this->valueExists($w, 'Date_out');
        }

        return $this->dateIfValid($date);
    }

    private function dateIfValid($date, $offset = false) {
        $minDate = strtotime('2010-01-01');

        if (!$date) {
            return null;
        }

        $date = date_create($date);

        $date = $offset ? date_sub($date, date_interval_create_from_date_string($offset)) : $date;

        return $date->getTimestamp() > $minDate ? $date->format('Y-m-d\TH:i:s') : null;
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = DB::table('old_networked')
            ->select(
                'InvoiceNumber',
                'DateSold',
                DB::raw("'!! old data' as notes")
            )
            ->distinct()
            ->where([
                ['InvoiceNumber', '<>', ''],
                ['InvoiceNumber', '<>', '0'],
            ])
            ->orderBy('DateSold', 'asc')
            ->get();
        $inserted = [];

        foreach ($products as $k => $p) {
            $inserted[] = [
                'invoice' => $p->InvoiceNumber,
                'notes' => $p->notes,
            ];
        }
        DB::table('sales')->insert($inserted);
    }
}

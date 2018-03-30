<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = DB::table('old_workshop_db')
            ->where([
                ['Item', '<>', ''],
                ['product_ref', '>', 0],
            ])
            ->get();

        $inserted = [];

        foreach ($products as $k => $w) {
            $inserted[] = [
                'workshop_number' => $w->product_ref,
                'notes' => $w->notes,
                'is_completed' => $w->IsCompleted,
            ];
        }
        DB::table('workshop')->insert($inserted);

        $inserted = [];
        $work = DB::table('old_workshop_work')
            ->where('product_ref', '>', 0)
            ->join('workshop', 'workshop.workshop_number', '=', 'old_workshop_work.product_ref')
            ->get();

        foreach ($work as $k => $w) {
            $inserted[] = [
                'workshop_id' => $w->id,
                'staff_name' => $w->staff_name,
                'notes' => $w->comments,
                'time_taken' => $w->time_taken_mins,
                'work_type' => $this->getWorkType($w->work_done),
            ];
        }
        DB::table('workshop_work')->insert($inserted);

        $inserted = [];
        $parts = DB::table('old_workshop_parts')
            ->where('product_ref', '>', 0)
            ->join('workshop', 'workshop.workshop_number', '=', 'old_workshop_parts.product_ref')
            ->get();

        foreach ($parts as $k => $p) {
            $inserted[] = [
                'workshop_id' => $p->id,
                'part_name' => $p->part_name,
                'ordered_by' => $p->ordered_by,
                'part_cost' => $p->part_cost,
                'notes' => $p->comments,
            ];
        }
        DB::table('workshop_parts')->insert($inserted);
    }

    private function getWorkType($workDone)
    {
        switch ($workDone) {
            case 'Testing':
                return 0;
            case 'Cleaning':
                return 1;
            case 'Repairs':
                return 2;
            case 'Parts Fitted':
                return 3;
            default:
                return 4;
        }
    }
}

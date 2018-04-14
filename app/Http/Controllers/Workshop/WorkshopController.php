<?php

namespace App\Http\Controllers\Workshop;

use App\Enums\ItemStatus;
use App\Models\Workshop;

use App\Http\Controllers\Controller;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{

    private $rows = [
        'id',
        'workshop_number',
        'notes',
        'is_completed'
    ];

    public function view($id)
    {
        $workshop = Workshop::select(...$this->rows)
            ->where('id', '=', $id)
            ->with([
                'item:name,workshop_id,serial_number,date_workshop_done,status,product_id',
                'work:workshop_id,updated_at,staff_name,notes,time_taken,work_type',
                'parts:workshop_id,updated_at,part_name,notes,ordered_by,notes,part_cost'
            ])
            ->first();

        return successResponse([
            'workshop' => $workshop
        ]);
    }

    public function edit(Request $req)
    {
        return successResponse([
            'endpoint' => 'Workshop edit',
            'request' => $req->all()
        ]);
    }

    public function list(Request $req)
    {
        $filters = [];
        $itemFilters = [];

        // for 'ready to go', 'long time in workshop'
        $toGo = $req->input('is-ready');
        if ($requestType === 'true') {
            $filters[] = ['is_completed', '=', 1];
            $itemFilters[] =  ['status', '<', ItemStatus::LiveOnRHC];
        } else if ($toGo === 'false') {
            $filters[] = ['is_completed', '=', 0];
            $itemFilters[] =  ['status', '<', ItemStatus::IsSold];
        }

        $days = $req->input('days-since-update');
        if ($days !== null) {
            $date = date_create();
            $dateFrom = date_sub($date, date_interval_create_from_date_string("$days days"));

            $itemFilters[] = ['created_at', '<', $dateFrom->format('Y-m-d\TH:i:s')];
        }

        $workshop = Workshop::select(...$this->rows)
            ->where($filters)
            ->whereHas('item', function ($q) use ($itemFilters) {
                $q->where($itemFilters);
            })
            ->with(['item:workshop_id,status,product_id,created_at'])
            ->get();

        return successResponse([
            'workshop' => $workshop,
            'count' => count($workshop)
        ]);
    }
}
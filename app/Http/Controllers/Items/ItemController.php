<?php

namespace App\Http\Controllers\Items;

use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    private $rowsList = [
        'id',
        'name',
        'status',
        'purchases_id',
        'workshop_id',
        'product_id',
        'sales_id',
        'date_sold',
        'created_at',
        'updated_at'
    ];

    private $rowsFull = [
        'id',
        'name',
        'status',
        'serial_number',
        'purchases_id',
        'date_purchased',
        'workshop_id',
        'date_workshop_done',
        'date_scrapped',
        'product_id',
        'date_on_site',
        'sales_id',
        'date_sold',
        'created_at',
        'updated_at'
    ];

    public function add(Request $req)
    {
        return successResponse([
            'endpoint' => 'Item Add',
            'request' => $req->all()
        ]);
    }

    public function view($id)
    {
        $item = Item::select(...$this->rowsFull)
            ->where('id', '=', $id)
            ->with([
                'purchase:id,purchase_ref',
                'workshop:id,workshop_number,notes,is_completed',
                'product:id,product_name,rhc_ref,rhc_status,curlew_status',
                'sales:id,invoice',
                // only get first image
                'image' => function ($q) {
                    $q->where('sort_order', '=', '0');
                }
            ])
            ->first();

        if (!$item) {
            return notFoundResponse();
        }

        return successResponse([
            'item' => $item
        ]);
    }

    public function list(Request $req)
    {
        // only be used for 'purchases' or 'status'
        $filters = $req->only(['purchases_id']);

        if ($status = $req->input('status')) {
            switch ($status) {
                case 'not sold':
                    $filters[] = ['status', '<', '4'];
                    break;
                case 'not on site':
                    $filters[] = ['status', '<', '3'];
                    break;
                default:
                    $filters[] = ['status', '=', $status];
            }
        }

        $order = $req->input('sort-by', ['created_at', 'desc']);

        $items = Item::select(...$this->rowsList)
            ->where($filters)
            ->orderBy(...$order)
            ->get();

        return successResponse([
            'items' => $items,
            'request' => $req->all()
        ]);
    }
}
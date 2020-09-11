<?php

namespace App\Repositories\User\Admin\Eloquent;
use App\Repositories\User\Admin\Interfaces\StockItemInterface;
use App\Models\Backend\StockItem;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;

class StockItemRepository extends BaseRepository implements StockItemInterface
{
    protected $model;

    public function __construct(StockItem $model)
    {
        $this->model = $model;
    }

    public function getActiveList($stockItemType = null) {
        $conditions = ['is_active' => ACTIVE_STATUS_ACTIVE];

        if( !is_null($stockItemType) ) {
            $conditions['item_type'] = $stockItemType;
        }

        return $this->model->select('id', DB::raw("CONCAT(item, ' (', item_name,')') AS item"))->where($conditions)->get();
    }

    public function getCountByConditions(array $conditions)
    {
        return $this->model->where($conditions)->count();
    }

    public function getStockPairsById($id)
    {
        return $this->model->where('id', $id)
            ->leftJoin('stock_pairs as base', 'base.base_item_id', '=', 'stock_items.id')
            ->leftJoin('stock_pairs as stock', 'stock.stock_item_id', '=', 'stock_items.id')
            ->select([
                // stock pair id
                'stock_items.*',
                // stock item
                'stock_item.id as stock_item_id',
                'stock_item.item as stock_item_abbr',
                'stock_item.item_name as stock_item_name',
                'stock_item.item_type as stock_item_type',
                // base item
                'base_item.id as base_item_id',
                'base_item.item as base_item_abbr',
                'base_item.item_name as base_item_name',
                'base_item.item_type as base_item_type',
                // 24hr pair detail
                'last_price',
                'exchange_24',
                //summary
                'stock_pairs.base_item_buy_order_volume',
                'stock_pairs.stock_item_buy_order_volume',
                'stock_pairs.base_item_sale_order_volume',
                'stock_pairs.stock_item_sale_order_volume',
                'stock_pairs.exchanged_buy_total',
                'stock_pairs.exchanged_sale_total',
                'stock_pairs.exchanged_amount',
                'stock_pairs.exchanged_maker_total',
                'stock_pairs.exchanged_buy_fee',
                'stock_pairs.exchanged_sale_fee',

            ]);
    }

    public function getStockItemJson()
    {
        $query = $this->model->all();
        return Datatables::of($query)
               ->addIndexColumn()
               ->editColumn('emoji',function($item){
                    if(!is_null(get_item_emoji($item->item_emoji))){
                     $img = '<img src='.get_item_emoji($item->item_emoji).' alt="Item Emoji" class="img-sm cm-center">';
                    }
                    else{
                     $img = '<i class="fa fa-money fa-lg text-green"></i>';
                    }

                    return $img;
               })
               ->editColumn('item-type', function($item){
                    return stock_item_types($item->item_type);
               })
               ->editColumn('status', function($item){
                    return  $item->is_active ? '<i class="fa fa-check text-green"></i>' :  '<i class="fa fa-close text-red"></i>';
               })
               ->editColumn('create', function($item){
                    return $item->created_at->toFormattedDateString();
               })
               ->addColumn('action' ,function($row){
                    $btn = '<div class="btn-group pull-right">
                                        <button class="btn green btn-xs btn-outline dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                <ul class="dropdown-menu dropdown-menu-stock-pair pull-right">';
                    if(has_permission('admin.stock-items.show')){
                        $btn .= ' <li>
                                        <a href='.route('admin.stock-items.show', $row->id).'><i
                                           class="fa fa-eye"></i>'.__('Show').'</a>
                                  </li>';
                    }

                    if(has_permission('admin.stock-items.edit')){
                        $btn .= ' <li>
                                        <a href='.route('admin.stock-items.edit', $row->id).'><i
                                                    class="fa fa-pencil"></i>'.__('Edit').'</a>
                                  </li>';
                    }

                    if(has_permission('admin.stock-items.toggle-status')){
                        $btn .= '<li>
                                    <a data-form-id="update-'.$row->id.'" data-form-method="PUT"
                                       href="'.route('admin.stock-items.toggle-status', $row->id).'" class="confirmation"
                                       data-alert="Do you want to change this stock items status?"><i
                                                class="fa fa-edit"></i>'.__('Change Status').'</a>
                                </li>';
                    }

                    if(has_permission('admin.stock-items.destroy')){
                        $btn .= '<li>
                                    <a data-form-id="delete-'.$row->id.'" data-form-method="DELETE"
                                       href="'.route('admin.stock-items.destroy', $row->id).'" class="confirmation"
                                       data-alert="'.__('Do you want to delete this stock item?').'"><i
                                                class="fa fa-trash-o"></i>'.__('Delete').'</a>
                                 </li>';
                    }

                    $btn .=      '</ul></div>';

                    return $btn;
               })->rawColumns(['emoji','item-type','status','create','action'])->make(true);
    }
}
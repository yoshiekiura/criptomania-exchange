<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\JobException;
use App\Http\Requests\User\Admin\StockPairRequest;
use App\Repositories\User\Admin\Interfaces\StockItemInterface;
use App\Repositories\User\Admin\Interfaces\StockPairInterface;
use App\Services\Core\DataListService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Models\Backend\StockPair;
use Illuminate\Http\Request;
use Validator;

class test extends Controller
{
   public function insert(Request $request){
          if($request->ajax())
     {
     $rules = array(
       'stock_item_id.*'  => 'required',
       'base_item_id.*'  => 'required',
       'last_price.*'  => 'required',
       'is_active.*'  => 'required',
       'is_default.*'  => 'required',

      );
     $error = Validator::make($request->all(), $rules);
      if($error->fails())
      {
       return response()->json([
        'error'  => $error->errors()->all()
       ]);
      }

      
      $stock_item_id = $request->stock_item_id;
      $base_item_id = $request->base_item_id;
      $last_price = $request->last_price;
      $is_active = $request->is_active;
      $is_default = $request->is_default;

      for($count = 0; $count < count($stock_item_id); $count++)
      {
       $data = array(
         'stock_item_id' => $stock_item_id[$count],
        'base_item_id'  => $base_item_id[$count],
        'last_price' => $last_price[$count],
        'is_active' => $is_active[$count],
        'is_default' => $is_default[$count]
       );
       $insert_data[] = $data; 
      }

      DB::table('stock_pairs')->insert($insert_data);
      return response()->json([
       'success'  => 'Data Added successfully.'
      ]);
     }
    }
}

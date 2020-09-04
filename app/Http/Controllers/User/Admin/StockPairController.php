<?php

namespace App\Http\Controllers\User\Admin;

use App\Exceptions\JobException;
use App\Http\Requests\User\Admin\StockPairRequest;
use App\Http\Requests\TestRequest;
use App\Repositories\User\Admin\Interfaces\StockItemInterface;
use App\Repositories\User\Admin\Interfaces\StockPairInterface;
use App\Services\Core\DataListService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Models\Backend\StockPair;
use Illuminate\Http\Request;
use Validator;

class StockPairController extends Controller
{
    public $stockPair;

    /**
     * StockPairController constructor.
     * @param StockPairInterface $stockPair
     */
    public function __construct(StockPairInterface $stockPair)
    {
        $this->stockPair = $stockPair;
    }

    /**
     * @developer: M.G. Rabbi
     * @date: 2018-10-18 3:57 PM
     * @description:
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
     public function json()
     {
      return $this->stockPair->allStockPairs();
     }
    public function index()
    {
        return view('backend.stockPairs.index');
    }

    /**
     * @developer: M.G. Rabbi
     * @date: 2018-10-18 5:45 PM
     * @description:
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // $default = StockPair::where('is_default', '=', 1)->get();

        $data['stockItems'] = app(StockItemInterface::class)->getActiveList()->pluck('item', 'id')->toArray();
        $data['title'] = __('Create Stock Pair');

        return view('backend.stockPairs.create', $data);
    }

    /**
     * @developer: M.G. Rabbi
     * @date: 2018-10-18 5:45 PM
     * @description:
     * @param StockPairRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

     public function store(StockPairRequest $request)
    {
        try {
            DB::beginTransaction();
            $attributes = $request->only('stock_item_id', 'base_item_id', 'is_active', 'last_price', 'is_default');

            if($request->is_default == ACTIVE_STATUS_ACTIVE) {
                $removePreviousDefaultStockPair = $this->stockPair->updateRows(['is_default' => ACTIVE_STATUS_INACTIVE], ['is_default' => ACTIVE_STATUS_ACTIVE]);

                if(!$removePreviousDefaultStockPair) {
                    DB::rollBack();

                    return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to create stock pair.'));
                }
            }

            $created = $this->stockPair->create($attributes);

            DB::commit();

            return redirect()->route('admin.stock-pairs.show', $created->id)->with(SERVICE_RESPONSE_SUCCESS, __('The stock pair has been created successfully.'));
        }
        catch (\Exception $exception) {
            DB::rollBack();
            if($exception->getCode() == 23000) {
                return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('The stock pair already exists.'));
            }

            return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to create stock pair.'));
        }
    }




    /**
     * @developer: M.G. Rabbi
     * @date: 2018-10-29 12:45 PM
     * @description:
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $data['title'] = __('Stock Pair');
        $data['stockPair'] = $this->stockPair->getFirstStockPairDetailByConditions(['stock_pairs.id' => $id]);

        return view('backend.stockPairs.show', $data);
    }

    /**
     * @developer: M.G. Rabbi
     * @date: 2018-10-20 11:42 PM
     * @description:
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data['stockItems'] = app(StockItemInterface::class)->getActiveList()->pluck('item', 'id')->toArray();
        $data['title'] = __('Edit Stock Pair');
        $data['stockPair'] = $this->stockPair->findOrFailById($id);

        return view('backend.stockPairs.edit', $data);
    }

    /**
     * @developer: M.G. Rabbi
     * @date: 2018-10-20 11:36 PM
     * @description:
     * @param StockPairRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StockPairRequest $request, $id)
    {
        $attributes = $request->only('stock_item_id', 'base_item_id', 'last_price');

        if ($this->stockPair->update($attributes, $id)) {
            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The stock pair has been updated successfully.'));
        }

        return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to update.'));
    }

    /**
     * @developer: M.G. Rabbi
     * @date: 2018-10-20 11:20 PM
     * @description:
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            if ($this->stockPair->deleteByConditions(['id' => $id, 'is_default' => ACTIVE_STATUS_INACTIVE])) {
                return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The stock pair has been deleted successfully.'));
            }

            return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to delete.'));
        } catch (\Exception $exception) {
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to delete as the stock pair is being used.'));
        }
    }

    /**
     * @developer: M.G. Rabbi
     * @date: 2018-10-20 11:20 PM
     * @description:
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActiveStatus($id)
    {
        $response = [SERVICE_RESPONSE_ERROR => __('Failed to change status.')];

        if ($updatedInstance = $this->stockPair->toggleStatusByConditions(['id' => $id, 'is_default' => ACTIVE_STATUS_INACTIVE])) {
            $message = $updatedInstance->is_active == ACTIVE_STATUS_ACTIVE ? __('The stock pair has been activated successfully.') : __('The stock pair has been deactivated successfully.');
            $response = [SERVICE_RESPONSE_SUCCESS => $message];
        }

        return redirect()->back()->with($response);
    }

    /**
     * @developer: M.G. Rabbi
     * @date: 2018-10-29 1:20 PM
     * @description:
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeStatusDefault($id)
    {
        DB::beginTransaction();

        try{

            $this->stockPair->updateRows(['is_default' => ACTIVE_STATUS_INACTIVE], ['is_default' => ACTIVE_STATUS_ACTIVE]);

            $updateDefaultStockPair = $this->stockPair->updateByConditions(['is_default' => ACTIVE_STATUS_ACTIVE], ['is_active' => ACTIVE_STATUS_ACTIVE, 'is_default' => ACTIVE_STATUS_INACTIVE, 'id' => $id]);

            if (!$updateDefaultStockPair) {
                throw new JobException(__('Failed to make default.'));
            }

        }catch (\Exception $exception){
            DB::rollBack();
            logs()->error("Make default stock pair: ".$exception->getMessage());
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to make default.'));
        }

        DB::commit();

        return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The stock pair has been made default successfully.'));
    }


    /**
     * @developer: Muhammad Rizky Firdaus
     * @date: 16/07/2020 22:23 PM
     * @description: Method multiIndex ini adalah method untuk menampilkan view form multiple input.
    */

    public function multiIndex(){

        $data['stockItems'] = app(StockItemInterface::class)->getActiveList()->pluck('item', 'id')->toArray();
        $data['title'] = __('Create Multiple Stock Pair');

        return view('backend.stockPairs.multi', $data);

    }


    /**
     * @developer: Muhammad Rizky Firdaus
     * @date: 16/07/2020 22:23 PM
     * @description: Method multiStore ini dibuat untuk menangani form input multiple, untuk saat ini rules
                     sudah berhasil dibuat dengan membuat aturan atau rules sendiri di dalam method multiStore ini.
                     Redirect juga sudah berhasil

    */

    public function multiStore(Request $request)
    {

         $this->validate($request, [
            'stock_item_name.*' => 'required|exists:stock_items,id,is_active,' . ACTIVE_STATUS_ACTIVE,
            'base_item_name.*' => 'required|different:stock_item_name.*|exists:stock_items,id,is_active,' . ACTIVE_STATUS_ACTIVE,
            'price_item_name.*' => 'required|numeric|between:0.00000001, 99999999999.99999999'
           // 'is_active' => 'required|in:0,1'
            // 'is_default.*' => 'required|in:0,1'
    ]);

        $coins = $request->stock_item_name;
        $base = $request->base_item_name;
        $price = $request->price_item_name;
        $active = $request->is_active;
        $default = $request->is_default;
        $date = now();

        $countr = count($coins);

        try {
                DB::beginTransaction();

                for ($i = 0; $i < $countr ; $i++) {

                $data = [
                    [
                        'stock_item_id' => $coins[$i],
                        'base_item_id' => $base[$i],
                        'is_active' => $active[$i],
                        'is_default' => 0,
                        'last_price' => $price[$i],
                        'created_at' => $date,
                        'updated_at' => $date

                    ]
                ];

                StockPair::insert($data);
            }

            DB::commit();

            return redirect()->route('admin.stock-pairs.index')->with(SERVICE_RESPONSE_SUCCESS, __('The stock pair has been created successfully.'));

        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception->getCode() == 23000) {
                return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('The stock pair already exists.'));
            }

            return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to create stock pair. Please Fill All Input Fields.'));
        }
    }



}

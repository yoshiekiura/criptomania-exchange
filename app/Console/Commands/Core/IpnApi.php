<?php

namespace App\Console\Commands\Core;


use Illuminate\Console\Command;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;
use App\Models\Backend\StockItem;



class IpnApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ipn:call';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call IPN Api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");

          $stock = StockItem::all()->pluck('item');
        foreach ($stock as $stockItem) {
            $request = Request::create('api/bitcoin/ipn/'.$stockItem, 'GET');
            $response = Route::dispatch($request);
        }

        $this->info('ipn:call Cummand Run successfully!');
    }
}

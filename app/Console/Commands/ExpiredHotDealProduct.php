<?php

namespace App\Console\Commands;

use App\Enums\HotDealStatus;
use App\Models\HotDealProduct;
use App\Models\Product;
use Illuminate\Console\Command;

class ExpiredHotDealProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deal:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change hot deal product status when expired';

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
        $ids = HotDealProduct::whereNotEnum('status', 'expired')->where('expired_at', '<', now())->pluck('product_id');
        HotDealProduct::whereIn('product_id', $ids)->update(['status' => HotDealStatus::expired()->getIndex()]);
        Product::whereIn('id', $ids)->update(['discount_price' => null]);
    }
}

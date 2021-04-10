<?php

namespace App\Console\Commands;

use App\Enums\CouponStatus;
use App\Model\Admin\Coupon;
use Illuminate\Console\Command;

class ExpiredCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change coupon status if expired';

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
        $ids = Coupon::whereNotEnum('status', 'expired')->where('expired_at', '<', now())->pluck('id');
        Coupon::whereIn('id', $ids)->update(['status' => CouponStatus::expired()->getIndex()]);
    }
}
// Coupon::where('status', '<>', '2')->where('expired_at', '<', now())->get()->toQuery()->update(['status' => "2"]); Laravel 7

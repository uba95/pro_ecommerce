<?php

namespace App\Events;

use App\Models\Brand;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CacheBrand 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        Cache::forget('brands');
        Cache::rememberForever('brands', function () {
            return Brand::orderBy('id')->get();
        });
    }
}

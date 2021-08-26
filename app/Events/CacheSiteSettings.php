<?php

namespace App\Events;

use App\Models\Category;
use App\Models\SiteSettings;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CacheSiteSettings
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        Cache::forget('site_settings');
        Cache::rememberForever('site_settings', function () {
            return SiteSettings::first();
        });
    }
}

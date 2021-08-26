<?php

namespace App\Models;

use App\Events\CacheSiteSettings;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'restrict_to_one_row';

    protected $dispatchesEvents = [
        'updated' => CacheSiteSettings::class,
    ];

}

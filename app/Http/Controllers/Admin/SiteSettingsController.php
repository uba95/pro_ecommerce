<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Dotenv\Dotenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class SiteSettingsController extends Controller
{
    public $config;

    public function __construct() {
        $this->middleware('can:view site settings',    ['only' => ['index']]);
        $this->middleware('can:edit site settings',    ['only' => ['edit', 'update']]);

        $this->config = (object) array_map(fn($v) => is_array($v) ? (object) $v : $v, config('shop'));
    }
    
    public function index() {
        return view('admin.site-settings.index', ['settings' => $this->config]);
    }

    public function edit() {
        
        return view('admin.site-settings.edit', ['settings' => $this->config]);
    }

    public function update(Request $request) {

        $data = collect($request->except('_token', '_method'))->map(fn($v, $k) => [strtoupper($k) => $v])->values()->collapse()->toArray();
        $this->setEnvironmentValue($data);
        Artisan::call('config:cache');

        return redirect()->route('admin.site_settings.index')->with(toastNotification('Site Settings', 'updated'));
    }
    public function setEnvironmentValue(array $values) {

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {

                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }

            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;
    }
}

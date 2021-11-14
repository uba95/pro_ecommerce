<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LandingPageRequest;
use App\Models\LandingPageItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    public function __construct() {
        $this->middleware('can:view landing page items',    ['only' => ['index', 'show']]);
        $this->middleware('can:create landing page items',  ['only' => ['create', 'store']]);
        $this->middleware('can:edit landing page items',    ['only' => ['edit', 'update', 'changeStatus']]);
        $this->middleware('can:delete landing page items',  ['only' => ['destroy']]);
    }

    public function index(Request $request) {

        $q = LandingPageItem::with('product:id,product_name');

        switch ($request->type) {
            case 'main_banner': $q->whereNotNull('is_main_banner'); break;
            case 'banner_slider': $q->whereNotNull('is_banner_slider'); break;
            case 'advert': $q->whereNotNull('is_advert'); break;
        }

        return view("admin.landing_page_items.$request->type.index", ['items' => $q->get()]);
    }
    
    public function show(LandingPageItem $item) {
        return view('admin.landing_page_items.show', compact('item')); 
    }

    public function create(Request $request) {
        return view("admin.landing_page_items.$request->type.create", [
            'products' => $request->type == 'advert' ? null : Product::orderBy('id')->pluck('product_name', 'id'),
        ]);
    }

    public function store(LandingPageRequest $request) {

        $attributes = $request->validated();

        foreach (['main_banner_img', 'banner_slider_img', 'advert_img'] as $v) {          
            $attributes[$v]  =  $request->hasFile($v) ? img_upload($request->file($v), LandingPageItem::IMAGES_STOREAGE) : null;
        }

        LandingPageItem::create($attributes);
        return redirect()->back()->with(toastNotification('Landing Page Item', 'created'));
    }

    public function edit(LandingPageItem $item) {
        $products = Product::orderBy('id')->pluck('product_name', 'id');       
        return view('admin.landing_page_items.edit', compact('item', 'products')); 
    }

    public function changeStatus(LandingPageItem $item) {
        $item->update(['status' => (int) !$item->status->getIndex()]);
        return redirect()->back()->with(toastNotification('Landing Page Item Status Changed Successfully'));     
    }

    public function update(LandingPageItem $item, LandingPageRequest $request) {

        $attributes = $request->validated();
// dd($attributes, $request->all());
        foreach (['main_banner_img', 'banner_slider_img', 'advert_img'] as $v) {          
            if ($request->hasFile($v)) {
                Storage::disk('public')->delete($item->getOriginal($v));
                $attributes[$v] = img_upload($request->file($v), LandingPageItem::IMAGES_STOREAGE);
            }
        }

        $item->update($attributes);  
        return back()->with(toastNotification('Landing Page Item', 'updated'));
    }

    public function destroy(LandingPageItem $item) {

        Storage::disk('public')->delete([
            $item->getOriginal('main_banner_img'),
            $item->getOriginal('banner_slider_img'),
            $item->getOriginal('advert_img'),
        ]);
        
        $item->delete();

        return redirect()->back()->with(toastNotification('Landing Page Item', 'deleted'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Admin\Subcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ParentController extends Controller
{
    public $model;
    public $name;
    public $path;
    public $data;

    public function __construct($model=[], $name=[], $path='', $data=[])
    {
        $this->model = $model;
        $this->name = $name;
        $this->path = $path;
        $this->data = $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->path, array_combine($this->name, $this->model));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(...$this->data);

        if($request->brand_logo) {
            
            $validatedData['brand_logo'] = $request->file('brand_logo')->store('media/brands', 'public');
        }

        $this->model[0]::create($validatedData);

        return redirect()->back()->with(toastNotification($this->name[0], 'added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view($this->path, array_combine($this->name, $this->model));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $resource =  $this->model[0];
        
        $validatedData = $request->validate(...$this->data);

        if($request->brand_logo) {

            $old_logo = $resource->getAttributes()['brand_logo'];

            if ($old_logo) {
                Storage::disk('public')->delete($old_logo);
            }

            $validatedData['brand_logo'] = $request->file('brand_logo')->store('media/brands', 'public');
        }

        $resource->update($validatedData);

        return redirect()->route($this->path)->with(toastNotification($this->name[0], 'updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = $this->model[0];
        
        if (isset($resource->getAttributes()['brand_logo'])) {

            Storage::disk('public')->delete($resource->getAttributes()['brand_logo']);
        }

        $resource->delete();

        return redirect()->back()->with(toastNotification($this->name[0], 'deleted'));
    }
}

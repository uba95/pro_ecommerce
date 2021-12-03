@extends('layouts.admin.index')


@section('admin_content')
<div class="container"><br><br><br><br><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Site Settings</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.site_settings.update') }}" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control"
                                name="shop_phone" value="{{ old('phone') ?? $settings->phone }}"  autocomplete="phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control"
                                name="shop_email" value="{{ old('email')  ?? $settings->email }}"  autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control"
                                name="shop_address" value="{{ old('address')  ?? $settings->address }}"  autocomplete="address" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="facebook" class="col-md-4 col-form-label text-md-right">{{ __('Facebook Page') }}</label>
                            <div class="col-md-6">
                                <input id="facebook" type="text" class="form-control"
                                name="shop_facebook" value="{{ old('facebook')  ?? $settings->facebook }}"  autocomplete="facebook" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="youtube" class="col-md-4 col-form-label text-md-right">{{ __('Youtube Channel') }}</label>
                            <div class="col-md-6">
                                <input id="youtube" type="text" class="form-control"
                                name="shop_youtube" value="{{ old('youtube')  ?? $settings->youtube }}"  autocomplete="youtube" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="twitter" class="col-md-4 col-form-label text-md-right">{{ __('Twitter Account') }}</label>
                            <div class="col-md-6">
                                <input id="twitter" type="text" class="form-control"
                                name="shop_twitter" value="{{ old('twitter')  ?? $settings->twitter }}"  autocomplete="twitter" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="instagram" class="col-md-4 col-form-label text-md-right">{{ __('Instagram Account') }}</label>
                            <div class="col-md-6">
                                <input id="instagram" type="text" class="form-control"
                                name="shop_instagram" value="{{ old('instagram')  ?? $settings->instagram }}"  autocomplete="instagram" autofocus>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="warehouse_phone" class="col-md-4 col-form-label text-md-right">{{ __('Warehouse Phone') }}</label>
                            <div class="col-md-6">
                                <input id="warehouse_phone" type="text" class="form-control"
                                name="warehouse_phone" value="{{ old('warehouse_phone')  ?? $settings->warehouse->phone }}"  autocomplete="warehouse_phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="warehouse_email" class="col-md-4 col-form-label text-md-right">{{ __('Warehouse Email') }}</label>
                            <div class="col-md-6">
                                <input id="warehouse_email" type="text" class="form-control"
                                name="warehouse_email" value="{{ old('warehouse_email')  ?? $settings->warehouse->email }}"  autocomplete="warehouse_email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="warehouse_address_1" class="col-md-4 col-form-label text-md-right">{{ __('Warehouse Address 1') }}</label>
                            <div class="col-md-6">
                                <input id="warehouse_address_1" type="text" class="form-control"
                                name="warehouse_address_1" value="{{ old('warehouse_address_1')  ?? $settings->warehouse->address_1 }}"  autocomplete="warehouse_address_1" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="warehouse_address_2" class="col-md-4 col-form-label text-md-right">{{ __('Warehouse Address 2') }}</label>
                            <div class="col-md-6">
                                <input id="warehouse_address_2" type="text" class="form-control"
                                name="warehouse_address_2" value="{{ old('warehouse_address_2')  ?? $settings->warehouse->address_2 }}"  autocomplete="warehouse_address_2" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="warehouse_zip" class="col-md-4 col-form-label text-md-right">{{ __('Warehouse Zip') }}</label>
                            <div class="col-md-6">
                                <input id="warehouse_zip" type="text" class="form-control"
                                name="warehouse_zip" value="{{ old('warehouse_zip')  ?? $settings->warehouse->zip }}"  autocomplete="warehouse_zip" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="warehouse_city" class="col-md-4 col-form-label text-md-right">{{ __('Warehouse City') }}</label>
                            <div class="col-md-6">
                                <input id="warehouse_city" type="text" class="form-control"
                                name="warehouse_city" value="{{ old('warehouse_city')  ?? $settings->warehouse->city }}"  autocomplete="warehouse_city" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="warehouse_state" class="col-md-4 col-form-label text-md-right">{{ __('Warehouse State') }}</label>
                            <div class="col-md-6">
                                <input id="warehouse_state" type="text" class="form-control"
                                name="warehouse_state" value="{{ old('warehouse_state')  ?? $settings->warehouse->state }}"  autocomplete="warehouse_state" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="warehouse_country" class="col-md-4 col-form-label text-md-right">{{ __('Warehouse Country') }}</label>
                            <div class="col-md-6">
                                <input id="warehouse_country" type="text" class="form-control"
                                name="warehouse_country" value="{{ old('warehouse_country')  ?? $settings->warehouse->country }}"  autocomplete="warehouse_country" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 mg-l-auto">
                                <div class="form-layout-footer">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Settings') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

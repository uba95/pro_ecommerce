@extends('admin.admin_layouts')


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
                                name="phone" value="{{ old('phone') ?? $settings->phone }}"  autocomplete="phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control"
                                name="email" value="{{ old('email')  ?? $settings->email }}"  autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control"
                                name="address" value="{{ old('address')  ?? $settings->address }}"  autocomplete="address" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="facebook" class="col-md-4 col-form-label text-md-right">{{ __('Facebook Page') }}</label>
                            <div class="col-md-6">
                                <input id="facebook" type="text" class="form-control"
                                name="facebook" value="{{ old('facebook')  ?? $settings->facebook }}"  autocomplete="facebook" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="youtube" class="col-md-4 col-form-label text-md-right">{{ __('Youtube Channel') }}</label>
                            <div class="col-md-6">
                                <input id="youtube" type="text" class="form-control"
                                name="youtube" value="{{ old('youtube')  ?? $settings->youtube }}"  autocomplete="youtube" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="twitter" class="col-md-4 col-form-label text-md-right">{{ __('Twitter Account') }}</label>
                            <div class="col-md-6">
                                <input id="twitter" type="text" class="form-control"
                                name="twitter" value="{{ old('twitter')  ?? $settings->twitter }}"  autocomplete="twitter" autofocus>
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

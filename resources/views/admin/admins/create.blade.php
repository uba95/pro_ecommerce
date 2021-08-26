@extends('admin.admin_layouts')


@section('admin_content')
<div class="container"><br><br><br><br><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Admin</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.admins.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') 'is-invalid' @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('Roles') }}</label>
                            <div class="col-md-6">
                                <div class="mg-t-20 mg-lg-t-0">
                                    <select name="roles[]" class="form-control select2 @error('roles') 'is-invalid' @enderror" multiple required>
                                        @foreach ($roles as $role_name)
                                            <option value="{{ $role_name }}">{{ ucwords($role_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @error('roles')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="avatar" class="col-form-label col-md-4 text-md-right">Avatar</label>
                            <div class="col-md-6" style="align-items: center; justify-content: space-between; display: flex;">
                                <label id="avatar" class="custom-file">
                                    <input type="file" class="@error('avatar') 'is-invalid' @enderror custom-file-input" name="avatar" onchange="readURL(this)">
                                    <span class="custom-file-control"></span>
                                </label>
                            </div>
                            @error('avatar')
                                <span class="invalid-feedback d-block" role="alert" style="margin: 10px auto">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
          
                        <div class="form-group row mb-0">
                            <div class="col-md-8 mg-l-auto">
                                <div class="form-layout-footer">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Admin') }}
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
    @push('scripts')
        <script type="text/javascript">
            function readURL(input){
            if (input.files) {
                $(input).parent().siblings('img').remove();
                Array.from(input.files).forEach(function (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                $(input).parent().parent().append(`<img src="${e.target.result}" width= "40" height= "40">`)
                };
                reader.readAsDataURL(file);
                });
            }
            }
        </script>
    @endpush

@endsection

@extends('layouts.admin.index')


@section('admin_content')
<div class="container"><br><br><br><br><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Admin</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.admins.update', $admin->id) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{  old('name') ?? $admin->name }}"
                                name="name" required autocomplete="name" autofocus>

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
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') ?? $admin->phone }}"
                                name="phone" required autocomplete="phone" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{  old('email') ?? $admin->email }}"
                                name="email" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('Roles') }}</label>
                            <div class="col-md-6">
                                <div class="mg-t-20 mg-lg-t-0">
                                    <select name="roles[]" class="form-control select2 @error('roles') 'is-invalid' @enderror" 
                                            @cannot('view roles') disabled @endcannot multiple required>
                                        @foreach ($roles as $role_name)
                                            <option value="{{ $role_name }}" {{ $adminRoles->contains($role_name) ? 'selected' : '' }}>{{ ucwords($role_name) }}</option>
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
                                <img src="{{ $admin->avatar }}" width= "40" height= "40">
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
                                        {{ __('Update Admin') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Change Password') }}</div>

                <div class="card-body">
                    <form method="POST" action ='{{ route('admin.admins.password.update', $admin->id) }}'>
                        @csrf @method('PUT')

                        <div class="form-group row">
                            <label for="oldpass" class="col-md-4 col-form-label text-md-right">{{ __('Old Password') }}</label>

                            <div class="col-md-6">
                                <input id="oldpass" type="password" class="form-control @error('oldpass') is-invalid @enderror" name="oldpass" required autofocus>
                                
                                @error('oldpass')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

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

                        <div class="form-group row mb-0">
                            <div class="col-md-8 mg-l-auto">
                                <div class="form-layout-footer">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Change Password') }}
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

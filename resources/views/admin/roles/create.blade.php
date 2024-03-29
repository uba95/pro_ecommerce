@extends('layouts.admin.index')
@section('admin_content')
<div class="container"><br><br><br><br><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Role</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Role Name') }}</label>
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
                            <label for="permissions" class="col-md-4 col-form-label text-md-right">{{ __('Permissions') }}</label>
                            <div class="col-md-6">
                                <div class="mg-t-20 mg-lg-t-0">
                                    <select name="permissions[]" class="form-control select2 @error('permissions') 'is-invalid' @enderror" multiple required>
                                        @foreach ($permissions as $id => $permission_name)
                                            <option value="{{ $id }}">{{ ucwords($permission_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @error('permissions')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                        </div>
                                  
                        <div class="form-group row mb-0">
                            <div class="col-md-8 mg-l-auto">
                                <div class="form-layout-footer">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Role') }}
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

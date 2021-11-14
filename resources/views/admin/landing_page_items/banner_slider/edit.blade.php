<div class="card">
    <div class="card-header">Edit Banner Slide</div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="mg-t-10"><strong>{{ $error }}</strong></li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.landing_page_items.update', $item->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <input type="hidden" name="is_banner_slider" value="1">
            <div class="form-group row">
                <label for="product_id" class="col-md-2 col-form-label text-md-right">{{ __('Product') }}</label>
                <div class="col-md-10">
                    <div class="mg-t-20 mg-lg-t-0">
                        <select name="product_id" class="form-control select2 select2-show-search required">
                            @foreach ($products as $id => $product_name)
                            <option value="{{ $id }}" {{ $id == ( old('product_id') ?? $item->product_id ) ? 'selected' : ''}}>
                                {{ ucwords($product_name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('product_id')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="banner_slider_text" class="col-md-2 col-form-label text-md-right">{{ __('Text') }}</label>

                <div class="col-md-10">
                    <textarea name="banner_slider_text" class="form-control">{{ old('banner_slider_text') ?? $item->banner_slider_text }}</textarea>
                    @error('banner_slider_text')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!-- col-4 -->

            <div class="form-group row">
                <label for="banner_slider_img" class="col-form-label col-md-2 text-md-right">Image</label>
                <div class="col-md-6" style="align-items: center; justify-content: space-between; display: flex;">
                    <label id="banner_slider_img" class="custom-file">
                        <input type="file" class="custom-file-input" name="banner_slider_img" onchange="readURL(this)">
                        <span class="custom-file-control"></span>
                    </label>
                    <img src="{{ $item->banner_slider_img }}" width= "40" height= "40">
                </div>
                @error('banner_slider_img')
                    <span class="invalid-feedback d-block px-3" role="alert" style="margin-left: 16.6667%">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row">
                <div class="col-lg-4" style="margin-left: 16.6667%">
                    <label class="ckbox">
                        <input name="status" type="hidden" value="inactive">
                        <input name="status" type="checkbox" value="active" {{ $item->status == 'active' ? 'checked' : '' }}>
                        <span>Active</span>
                    </label>
                </div><!-- col-4 -->
            </div>


            <div class="form-group row mb-0">
                <div class="col-md-8" style="margin-left: 16.6667%">
                    <div class="form-layout-footer">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update Banner Slide') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

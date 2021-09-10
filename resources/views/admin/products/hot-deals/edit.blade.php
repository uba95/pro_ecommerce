@extends('layouts.admin.index')


@section('admin_content')
<div class="container"><br><br><br><br><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card pd-20 pd-sm-40">
                <h6 class="card-body-title">Edit Hot Deal Product </h6>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <h6 class="card-header">Product Details</h6>
                            <div class="card-body">
                                <table class="table">

                                    <tr>
                                        <th> Name: </th>
                                        <th> {{ $deal->product->product_name }} </th>
                                    </tr>

                                    <tr>
                                        <th> Quantity: </th>
                                        <th>{{ $deal->product->product_quantity }} </th>
                                    </tr>

                                    <tr>
                                        <th> Selling Price: </th>
                                        <th> {{ $deal->product->selling_price }}$</th>
                                    </tr>

                                    <tr>
                                        <th> Discount Price: </th>
                                        <th> {{ $deal->product->discount_price }}$</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <img src="{{ $deal->product->cover }}" alt="">
                    </div>
                </div>

            </div>

            <div class="card">
                <h6 class="card-header">Edit Hot Deal</h6>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action='{{ route('admin.products.hot_deals.update', $deal->product->id) }}' method="POST">
                        @csrf @method('PUT')
                        <div class="pd-20">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Deal Price</label>
                                <input type="number" class="form-control" name="discount_price" min="0"
                                    max="{{ $deal->product->selling_price }}"
                                    value="{{ $deal->product->discount_price }}">
                            </div>
                            <div class="form-group">
                                <label class="ckbox">
                                    <input name="status" type="hidden" value="inactive">
                                    <input name="status" type="checkbox" value="active" {{ $deal->status == 'active' ? 'checked' : '' }}>
                                    <span>Active</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <div>Start At</div>
                                <input type="date" class="form-control" name="started_at" value="{{ $deal->started_at->isoFormat('Y-MM-DD') }}">
                            </div>
                            <div class="form-group">
                                <div>Expire At</div>
                                <input type="date" class="form-control" name="expired_at" value="{{ $deal->expired_at->isoFormat('Y-MM-DD') }}">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success" type="submit">Update Hot Deal</button>
                            </div>
                        </div><!-- modal-body -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
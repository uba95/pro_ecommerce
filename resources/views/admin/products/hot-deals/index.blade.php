@extends('layouts.admin.index')


@section('admin_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Hot Deals Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">
                Hot Deals List
            </h6>

            <div class="table-wrapper">
                <table id="datatable1" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p">SKU</th>
                            <th class="wd-15p">Product Name</th>
                            <th class="wd-15p">Product Quantity</th>
                            <th class="wd-15p">Deal Price</th>
                            <th class="wd-15p">Status</th>
                            <th class="wd-15p">Started At</th>
                            <th class="wd-15p">Expired At</th>
                            @canany(['edit products', 'delete products'])
                            <th class="wd-20p" data-orderable="false" data-searchable="false">Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deals as $deal)
                        <tr>
                            <td>{{ $deal->product->sku }}</td>
                            <td><a
                                    href='{{ route('admin.products.show', $deal->product_id) }}'>{{ $deal->product->product_name }}</a>
                            </td>
                            <td>{{ $deal->product->product_quantity }}</td>
                            <td>{{ $deal->product->discount_price }}</td>
                            <td>
                                @switch($deal->status)
                                @case('inactive')
                                    <span class="badge badge-dark">INACTIVE</span>
                                    @break
                                @case('active')
                                    <span class="badge badge-success">ACTIVE</span>
                                    @break
                                @case('expired')
                                    <span class="badge badge-danger">EXPIRED</span>
                                    @break
                                @endswitch
                            </td>
                            <td>{{ $deal->started_at->isoFormat('Y-MM-DD') }}</td>
                            <td>{{ $deal->expired_at->isoFormat('Y-MM-DD') }}</td>
                            @canany(['edit products', 'delete products'])
                                <td class="d-flex">
                                    @can('edit products')
                                    <a href='{{ route('admin.products.hot_deals.edit', $deal->product_id) }}'>
                                        <i class=" btn btn-sm btn-info fa fa-edit fa-fw" title="edit"></i></a>
                                    @endcan
                                    @can('delete products')
                                    <form method="POST" action='{{ route('admin.products.hot_deals.destroy', $deal->product_id) }}'
                                        class="delete">
                                        @csrf @method('DELETE')
                                        <i class=" btn btn-sm btn-danger fa fa-trash fa-fw" title="delete"></i>
                                    </form>
                                    @endcan
                                </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div><!-- card -->
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection
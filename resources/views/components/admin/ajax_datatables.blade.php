@switch($column)

    @case('show')
        {{-- @can($permissions) --}}
            <td>
                {{-- <a href ='{{ route('admin.'.$route.'.show', $id) }}'>{{ $name }}</a> --}}
                {{ $name }}
            </td>
        {{-- @endcan --}}
        @break

    @case('status')
        <td>
            @if (isset($order))
                @include('layouts.orders.order_status')
            @elseif (isset($cancelRequest))
                @include('layouts.orders.cancel_order_request_status', ['request' => $cancelRequest])
            @elseif (isset($returnRequest))
                @include('layouts.orders.return_order_request_status', ['request' => $returnRequest])
            @else
                <span class="badge {{ $status->isActive() ? "badge-success" : "badge-danger" }}">
                    {{ $status->getName() }}
                </span>
            @endif
        </td>
        @break

    @case('cover')
        <td>
            <img src="{{ $cover }}" alt="" width="70">
        </td>
        @break

    @case('total_price')
        <td>
            <span class="badge badge-success" style="font-size: 85%">{{ $total_price }} $</span>
        </td>
        @break

    @case('action')
        @canany(...array_values($permissions))
        <td>
            @php
                $model->id ??= $model->product_id;
            @endphp
            <div class="dropdown text-center" style="cursor: pointer">
                <a class="dropdown-button p-4" id="dropdown-menu-{{ $model->id }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-menu-{{ $model->id }}">

                    @isset($permissions['view'])
                        @can($permissions['view'])
                        <a href='{{ route('admin.'.$route.'.show', $model->id) }}' class="dropdown-item px-1">
                            <i class="fa fa-eye fa-fw mr-1" ></i>Show {{ $view ?? '' }}
                        </a>
                        @endcan
                        @if($permissions['view'] == 'view orders')
                            @if ($model->order_id)
                                <a href='{{ route('admin.orders.show', $model->order_id) }}' class="dropdown-item px-1">
                                    <i class="fa fa-list fa-fw mr-1" ></i>Show Order
                                </a>    
                            @endif
                            @if ($model->user_id ?? $model->order->user_id)
                                <a href='{{ route('admin.customers.show', $model->user_id ?? $model->order->user_id) }}' class="dropdown-item px-1">
                                    <i class="fa fa-user fa-fw mr-1" ></i>Show Customer
                                </a>    
                            @endif
                        @endif
                    @endisset

                    @isset($permissions['edit'])
                        @can($permissions['edit'])
                        <a href='{{ route('admin.'.$route.'.edit', $model->id) }}' class="dropdown-item px-1">
                            <i class="fa fa-edit fa-fw mr-1" ></i>Edit
                        </a>
                        @if($route == 'products')
                        <a href ='{{ route('admin.'.$route.'.status', $model->id) }}' class="dropdown-item px-1">
                            <i class="fa fa-lightbulb-o fa-fw mr-1" ></i>Change Status
                        </a>
                        @endif
                        @endcan
                    @endisset
                    @isset($permissions['reply'])
                        @can($permissions['reply'])
                        <a href ='{{ route('admin.'.$route.'.reply', $model->id) }}' class="dropdown-item px-1">
                            <i class="fa fa-reply fa-fw mr-1" ></i>Reply
                        </a>
                        @endcan 
                    @endisset       
                    @isset($permissions['delete'])
                        @can($permissions['delete'])
                            <form method="POST" action='{{ route('admin.'.$route.'.destroy', $model->id) }}'
                                class="dropdown-item px-1 delete">
                                @csrf @method('DELETE') 
                                <i class="fa fa-times fa-fw mr-1" ></i>Delete
                            </form>
                        @endcan 
                    @endisset       
                </div>
            </div>
        </td>
        @endcanany
        @break
@endswitch

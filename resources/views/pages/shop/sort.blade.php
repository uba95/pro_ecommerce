{{ ucfirst(request()->sort ?? 'date')}}

<a href ='{{ route('shop.index', request()->except('page', 'order') +  ['order' => request()->order == 'asc'?  'desc' : 'asc' ]) }}'
    ajax ='{{ route('shop.index', request()->except('page')) }}'
>
<i class="fas {{ request()->order == 'asc'?  'fa-sort-amount-down' : 'fa-sort-amount-up' }} text-primary" style="font-size: 14px;"></i>
</a>

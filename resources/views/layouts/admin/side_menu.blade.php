    <!-- ########## START: LEFT PANEL ########## -->
    <div class="sl-logo"><a href='{{ url('admin/') }}'><i class="icon ion-android-star-outline"></i> Ecommmerce</a></div>
    <div class="sl-sideleft">
      <div class="sl-sideleft-menu">

        <a href='{{ url('admin/') }}' class="sl-menu-link active">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Dashboard</span>
          </div><!-- menu-item -->
        </a>

        <!-- sl-menu-link -->
        @can('view admins')
          @component('components.admin.side_menu_links')
            @slot('title') Admins @endslot
            @can('view admins')
              <li class="nav-item"><a href ='{{ route('admin.admins.index') }}' class="nav-link">All Admins</a></li>
            @endcan
            @can('create admins')
              <li class="nav-item"><a href ='{{ route('admin.admins.create') }}' class="nav-link">Add New Admin</a></li>
            @endcan
          @endcomponent
        @endcan

        @canany(['view roles', 'view permissions'])
          @component('components.admin.side_menu_links')
            @slot('title') Roles & Permissions @endslot
            @can('view roles')
              <li class="nav-item"><a href ='{{ route('admin.roles.index') }}' class="nav-link">All Roles</a></li>
            @endcan
            @can('view permissions')
              <li class="nav-item"><a href ='{{ route('admin.permissions.index') }}' class="nav-link">All Permissions</a></li>
            @endcan
          @endcomponent
        @endcanany

        @can('view categories')
          @component('components.admin.side_menu_links')
            @slot('title') Categories @endslot
            <li class="nav-item"><a href ='{{ route('admin.categories.index') }}' class="nav-link">Categories</a></li>
            <li class="nav-item"><a href ='{{ route('admin.subcategories.index') }}' class="nav-link">Subcategories</a></li>
            <li class="nav-item"><a href ='{{ route('admin.brands.index') }}' class="nav-link">Brands</a></li>
          @endcomponent
        @endcan

        @can('view products')
          @component('components.admin.side_menu_links')
            @slot('title') Products @endslot
            @can('view products')
              <li class="nav-item"><a href ='{{ route('admin.products.index') }}' class="nav-link">All Products</a></li>
            @endcan
            @can('create products')
              <li class="nav-item"><a href ='{{ route('admin.products.create') }}' class="nav-link">Add New Product</a></li>
            @endcan
          @endcomponent
        @endcan
        
        @can('view orders')
          @component('components.admin.side_menu_links')
            @slot('title') Orders @endslot
            <li class="nav-item"><a href ='{{ route('admin.orders.index') }}' class="nav-link">All Orders</a></li>
            @foreach (App\Enums\OrderStatus::getValues() as $status)
              <li class="nav-item">
                <a href ='{{ route('admin.orders.index', ['status' => $status]) }}' class="nav-link">
                  {{ camelToTitle($status) }}
                </a>
              </li>
            @endforeach
          @endcomponent

          @component('components.admin.side_menu_links')
            @slot('title') Cancel Order Requests @endslot
            <li class="nav-item"><a href ='{{ route('admin.cancel_orders.index') }}' class="nav-link">All Cancel Requests</a></li>
            @foreach (App\Enums\CancelOrderStatus::getValues() as $status)
              <li class="nav-item">
                <a href ='{{ route('admin.cancel_orders.index', ['status' => $status]) }}' class="nav-link">
                  {{ camelToTitle($status) }}
                </a>
              </li>
            @endforeach
          @endcomponent
          
          @component('components.admin.side_menu_links')
            @slot('title') Return Order Requests @endslot
            <li class="nav-item"><a href ='{{ route('admin.return_orders.index') }}' class="nav-link">All Return Requests</a></li>
            @foreach (App\Enums\ReturnOrderStatus::getValues() as $status)
              <li class="nav-item">
                <a href ='{{ route('admin.return_orders.index', ['status' => $status]) }}' class="nav-link">
                  {{ camelToTitle($status) }}
                </a>
              </li>
            @endforeach
          @endcomponent
        @endcan

        @can('view stocks')
          @component('components.admin.side_menu_links')
            @slot('title') Stocks @endslot
            <li class="nav-item"><a href ='{{ route('admin.stocks.index') }}' class="nav-link">All Stocks</a></li>
            <li class="nav-item"><a href ='{{ route('admin.stocks.index', ['status' => 'in']) }}' class="nav-link">In Stock</a></li>
            <li class="nav-item"><a href ='{{ route('admin.stocks.index', ['status' => 'only']) }}' class="nav-link">Few Stock</a></li>
            <li class="nav-item"><a href ='{{ route('admin.stocks.index', ['status' => 'out']) }}' class="nav-link">Out Of Stock</a></li>
          @endcomponent
        @endcan

        @can('view blog')
          @component('components.admin.side_menu_links')
            @slot('title') Blog @endslot
            <li class="nav-item"><a href ='{{ route('admin.blog_categories.index') }}' class="nav-link">Blog Categories</a></li>
            <li class="nav-item"><a href ='{{ route('admin.blog_posts.index') }}' class="nav-link">Blog Posts</a></li>
            @can('create blog')
              <li class="nav-item"><a href ='{{ route('admin.blog_posts.create') }}' class="nav-link">Add New Post</a></li>
            @endcan
          @endcomponent
        @endcan

        @can('view reports')
          @component('components.admin.side_menu_links')
            @slot('title') Reports @endslot
            <a href ='{{ route('admin.reports.salesBy') }}' class="nav-link">Sales By Products</a>
            @foreach (['sales', 'returns', 'net_sales', 'orders', 'sold_products', 'others'] as $report)
            <li class="nav-item">
              <a href ='{{ route('admin.reports.index', ['report' => $report]) }}' class="nav-link">{{ snakeToTitle($report) }}</a>
            </li>
            @endforeach
          @endcomponent
        @endcan

        @can('view customers')
          <a href ='{{ route('admin.customers.index') }}' class="sl-menu-link">
            <div class="sl-menu-item">
              <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
              <span class="menu-item-label">Customers</span>
            </div><!-- menu-item -->
          </a>
        @endcan

        @can('view contact messages')
        <a href ='{{ route('admin.contact.messages.index') }}' class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Contact Messages</span>
          </div><!-- menu-item -->
        </a>
        @endcan

        @canany(['view coupons', 'view newslaters', 'view site settings'])
          @component('components.admin.side_menu_links')
            @slot('title') Others @endslot
            @can('view coupons')
              <li class="nav-item"><a href ='{{ route('admin.coupons.index') }}' class="nav-link">Coupons</a></li>
            @endcan
            @can('view newslaters')
              <li class="nav-item"><a href ='{{ route('admin.newslaters.index') }}' class="nav-link">Newslaters</a></li>
            @endcan
            @can('view site settings')
              <li class="nav-item"><a href ='{{ route('admin.site_settings.index') }}' class="nav-link">Site Settings</a></li>
            @endcan
          @endcomponent
        @endcanany

      </div><!-- sl-sideleft-menu -->
      <br>
    </div><!-- sl-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->
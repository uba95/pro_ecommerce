<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // dd(ReportService::mostSoldProductsThisMonth());
      return view('admin.home', [
        // 'models' => ReportService::dashboardStatModels(),
        // 'modelsNames' => ['Sales',  'Orders', 'Sold Products', 'Others'],
        'latest_orders' => Order::latest('id')->limit(5)->get(),
        // 'latest_sold_order_items' => OrderItem::with('product')->latest('id')->groupBy('product_id')->limit(5)->get(['id', 'product_id', 'product_name', 'product_quantity']),
        'mostSoldProductsThisMonth' => ReportService::mostSoldProductsThisMonth(),
        'lists' => [ReportService::last30Days(), ReportService::priceTotals()],
        'listsNames' => ['Last 30 Days Totals',  'Price Totals'],
        'paymentMethods' => ReportService::paymentMethods(),
      ]);
      // return view('admin.home', [
      //   'overtime_sales' => Order::sold()->sum('total_price'),
      //   'year_sales' => Order::sold()->thisYear()->sum('total_price'),
      //   'month_sales' => Order::sold()->thisYear()->whereMonth('created_at', now()->month)->sum('total_price'),
      //   'today_sales' => Order::sold()->whereDate('created_at', today())->sum('total_price'),
      //   'total_products' => Product::count(),
      //   'total_orders' => Order::count(),
      //   'total_users' => User::count(),
      //   'latest_users' => User::latest('id')->limit(5)->get(),
      //   'latest_sold_order_items' => OrderItem::latest('id')->groupBy('product_id')->limit(5)->get(['id', 'product_id', 'product_name', 'product_quantity']),
      // ]);
      // $orders_year = Order::whereNotEnum('status', ['pending', 'canceled'])
      // ->whereYear('created_at', now()->year)
      // ->get(['id', 'created_at','total_price']);
      // return view('admin.home', [
      //   'year_sales' => $orders_year->sum->total_price,
      //   'month_sales' => $orders_year->filter(fn($v) => $v->created_at->isCurrentMonth())->sum->total_price,
      //   'week_sales' => $orders_year->filter(fn($v) => $v->created_at->isCurrentWeek())->sum->total_price,
      //   'today_sales' => $orders_year->filter(fn($v) => $v->created_at->isToday())->sum->total_price,
      // ]);
    }

    public function ChangePassword()
    {
        return view('admin.auth.passwordchange');
    }

    public function Update_pass(Request $request)
    {
      $password=Auth::user()->password;
      $oldpass=$request->oldpass;
      $newpass=$request->password;
      $confirm=$request->password_confirmation;
      if (Hash::check($oldpass,$password)) {
           if ($newpass === $confirm) {
                      $user=Admin::find(Auth::id());
                      $user->password=Hash::make($request->password);
                      $user->save();
                      Auth::logout();  
                      $notification=array(
                        'message'=>'Password Changed Successfully ! Now Login with Your New Password',
                        'alert-type'=>'success'
                         );
                       return Redirect()->route('admin.login')->with($notification); 
                 }else{
                     $notification=array(
                        'message'=>'New password and Confirm Password not matched!',
                        'alert-type'=>'error'
                         );
                       return Redirect()->back()->with($notification);
                 }     
      }else{
        $notification=array(
                'message'=>'Old Password not matched!',
                'alert-type'=>'error'
                 );
               return Redirect()->back()->with($notification);
      }
    }

    public function logout()
    {
        Auth::logout();
            $notification=array(
                'message'=>'Successfully Logout',
                'alert-type'=>'success'
                 );
             return Redirect()->route('admin.login')->with($notification);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\OrderIteam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\medicine;
use App\Models\Order;

class dashboardController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Karachi');
        $current_time = Carbon::now('Asia/Karachi')->toDateString();
        $today_sell_price = OrderIteam::whereDate('created_at', $current_time)->sum('total_price');
        $startOfWeek = Carbon::now('Asia/Karachi')->startOfWeek();
        $endOfWeek = Carbon::now('Asia/Karachi')->endOfWeek();
        $startOfMonth = Carbon::now('Asia/Karachi')->startOfMonth();
        $endOfMonth = Carbon::now('Asia/Karachi')->endOfMonth();
        $lastMonthStartDate = $startOfMonth = Carbon::now('Asia/Karachi')->subMonth()->startOfMonth()->format('d-m-Y');
        $lastMonthEndtDate = $startOfMonth = Carbon::now('Asia/Karachi')->subMonth()->endOfMonth()->format('d-m-Y');

        return response()->json([
            'total_sell_price'=> OrderIteam::sum('total_price'),
            'today_sell_price' => $today_sell_price,
            'current_week_sell_price' => OrderIteam::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('total_price'),
            'current_month_sell_price' => OrderIteam::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_price'),
            'last_month_sell_price' => OrderIteam::whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndtDate])->sum('total_price'),
            'total_oders' => Order::count(),
            'total_customer' => Customer::count(),
            'total_midcine' => medicine::count(),
            'total_Category' => Category::count(),
            'latest_customers' => Customer::latest('id')->take(4)->get(),
        ]);
    }
}

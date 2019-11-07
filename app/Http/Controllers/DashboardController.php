<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard.home');
    }

    public function totalUserChart()
    {
        $startDate = new Carbon('first day of last month');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new Carbon('last day of this month');
        $endDate = $endDate->format('Y-m-d');

        $data = [
          'startDate' => $startDate,
          'endDate' => $endDate
        ];

        return view('dashboard.chart.user', $data);
    }

    public function revenueChart()
    {
        $startDate = new Carbon('first day of last month');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new Carbon('last day of this month');
        $endDate = $endDate->format('Y-m-d');

        $data = [
          'startDate' => $startDate,
          'endDate' => $endDate
        ];

        return view('dashboard.chart.revenue', $data);
    }

    public function abandonCheckoutChart()
    {
        $startDate = new Carbon('first day of last month');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new Carbon('last day of this month');
        $endDate = $endDate->format('Y-m-d');

        $data = [
          'startDate' => $startDate,
          'endDate' => $endDate
        ];

        return view('dashboard.chart.checkout', $data);
    }

    public function averageOrderChart()
    {
        return view('dashboard.chart.order');
    }

    public function totalTransactionChart()
    {
        return view('dashboard.chart.transaction');
    }

    public function paidUserChart()
    {
        return view('dashboard.chart.paid');
    }

}

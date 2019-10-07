<?php

namespace App\Http\Controllers;

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
        return view('dashboard.chart.user');
    }

    public function revenueChart()
    {
        return view('dashboard.chart.revenue');
    }

    public function checkoutChart()
    {
        return view('dashboard.chart.checkout');
    }

    public function loginChart()
    {
        return view('dashboard.chart.login');
    }

    public function retentionChart()
    {
        return view('dashboard.chart.retention');
    }
}

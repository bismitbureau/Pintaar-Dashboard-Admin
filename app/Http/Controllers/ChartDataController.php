<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\CarbonPeriod;
use App\Models\User;
use App\Models\PembelianCourse;
use Illuminate\Http\Request;

class ChartDataController extends Controller
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

    public function generateExcludedDateData($startDate, $endDate)
    {
        $newUndefinedDateJson = [];
        $period = CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            $newUndefinedDateJson[] = [$date->format('D, d M Y'), 0];
        }
        return $newUndefinedDateJson;
    }

    public function generateCountedData($data, $startDate, $endDate)
    {
        $dataJson = [];
        $previous_date = $data->first()->created_at->format('Y-m-d');
        $count = 0;

        $dataJson = $this->generateExcludedDateData($startDate, $previous_date);
        array_pop($dataJson);

        foreach ($data as $this_data)
        {
            $this_date = $this_data->created_at->format('Y-m-d');
            if ($this_date != $previous_date) {

                $dataJson[] = [date("D, d M Y", strtotime($previous_date)), $count];

                $newUndefinedDateJson = $this->generateExcludedDateData($previous_date, $this_date);
                array_shift($newUndefinedDateJson);
                array_pop($newUndefinedDateJson);
                $dataJson = array_merge($dataJson, $newUndefinedDateJson);

                $previous_date = $this_date;
                $count = 0;
            }
            $count += 1;
        }
        $dataJson[] = [date("D, d M Y", strtotime($this_date)), $count];

        $lastPeriod = $this->generateExcludedDateData($this_date, $endDate);
        array_shift($lastPeriod);
        $dataJson = array_merge($dataJson, $lastPeriod);

        return $dataJson;
    }

    public function generateSummedTotalCartData($data, $startDate, $endDate)
    {
        $dataJson = [];
        $previous_date = $data->first()->created_at->format('Y-m-d');
        $sum = 0;

        $dataJson = $this->generateExcludedDateData($startDate, $previous_date);
        array_pop($dataJson);

        foreach ($data as $this_data)
        {
            $this_date = $this_data->created_at->format('Y-m-d');
            if ($this_date != $previous_date) {

                $dataJson[] = [date("D, d M Y", strtotime($previous_date)), $sum];

                $newUndefinedDateJson = [];
                $period = CarbonPeriod::create($previous_date, $this_date);
                foreach ($period as $date) {
                  $newUndefinedDateJson[] = [$date->format('D, d M Y'), 0];
                }

                array_shift($newUndefinedDateJson);
                array_pop($newUndefinedDateJson);
                $dataJson = array_merge($dataJson, $newUndefinedDateJson);

                $previous_date = $this_date;
                $sum = 0;
            }
            $sum += $this_data->getCart->total_price;
        }

        $dataJson[] = [date("D, d M Y", strtotime($this_date)), $sum];

        $lastPeriod = $this->generateExcludedDateData($this_date, $endDate);
        array_shift($lastPeriod);
        $dataJson = array_merge($dataJson, $lastPeriod);

        return $dataJson;
    }

    public function generateAverageTotalCartData($data, $startDate, $endDate)
    {
        $dataJson = [];
        $previous_date = $data->first()->created_at->format('Y-m-d');
        $sum = 0;
        $count = 0;

        $dataJson = array_merge($dataJson, $this->generateExcludedDateData($startDate, $previous_date));
        array_shift($dataJson);

        foreach ($data as $this_data)
        {
            $this_date = $this_data->created_at->format('Y-m-d');
            if ($this_date != $previous_date) {

                $dataJson[] = [date("D, d M Y", strtotime($previous_date)), $sum / $count];

                $newUndefinedDateJson = [];
                $period = CarbonPeriod::create($previous_date, $this_date);
                foreach ($period as $date) {
                    $newUndefinedDateJson[] = [$date->format('D, d M Y'), 0];
                }

                array_shift($newUndefinedDateJson);
                array_pop($newUndefinedDateJson);
                $dataJson = array_merge($dataJson, $newUndefinedDateJson);

                $previous_date = $this_date;
                $sum = 0;
                $count = 0;
            }
            $sum += $this_data->getCart->total_price;
            $count += 1;
        }

        $dataJson[] = [date("D, d M Y", strtotime($this_date)), $sum / $count];

        $lastPeriod = $this->generateExcludedDateData($this_date, $endDate);
        array_shift($lastPeriod);
        $dataJson = array_merge($dataJson, $lastPeriod);

        return $dataJson;
    }

    public function generateAbandonCheckoutData($data, $startDate, $endDate)
    {
        $dataJson = [];
        $previous_date = $data->first()->created_at->format('Y-m-d');
        $count1 = 0;
        $count2 = 0;

        $dataJson = array_merge($dataJson, $this->generateExcludedDateData($startDate, $previous_date));
        array_shift($dataJson);

        foreach ($data as $this_data)
        {
            $this_date = $this_data->created_at->format('Y-m-d');
            if ($this_date != $previous_date) {

                $dataJson[] = [date("D, d M Y", strtotime($previous_date)), $count1 / $count2];

                $newUndefinedDateJson = [];
                $period = CarbonPeriod::create($previous_date, $this_date);
                foreach ($period as $date) {
                    $newUndefinedDateJson[] = [$date->format('D, d M Y'), 0];
                }

                array_shift($newUndefinedDateJson);
                array_pop($newUndefinedDateJson);
                $dataJson = array_merge($dataJson, $newUndefinedDateJson);

                $previous_date = $this_date;
                $count1 = 0;
                $count2 = 0;
            }
            if ($this_data->status_pembayaran == 1) {
                $count1 += 1;
            }
            $count2 += 1;
        }

        $dataJson[] = [date("D, d M Y", strtotime($this_date)), $count1 / $count2];

        $lastPeriod = $this->generateExcludedDateData($this_date, $endDate);
        array_shift($lastPeriod);
        $dataJson = array_merge($dataJson, $lastPeriod);

        return $dataJson;
    }

    public function totalUser($startDate, $endDate)
    {
        $data = User::whereBetween('created_at', [date($startDate), date($endDate)])
            ->orderBy('created_at', 'ASC')
            ->get();

        $dataJson = $this->generateCountedData($data, $startDate, $endDate);

        return response()->json($dataJson);
        }

    public function revenue($startDate, $endDate)
    {
        $data = PembelianCourse::where('status_pembayaran', 3)
            ->whereBetween('created_at', [date($startDate), date($endDate)])
            ->whereHas('getCart', function ($query) {
                $query->where('total_price', '>', 0)
                    ->whereHas('getCartCourses', function ($query) {
                        $query->where('course_price', '>', 0)
                            ->whereNotNull('course_price');
                    });
            })
            ->whereNotNull('bukti_pembayaran')
            ->whereNotNull('metode_pembayaran')
            ->orderBy('created_at', 'ASC')
            ->get();

        $dataJson = $this->generateSummedTotalCartData($data, $startDate, $endDate);

        return response()->json($dataJson);
    }

    public function abandonCheckout($startDate, $endDate)
    {
        $data = PembelianCourse::where('is_visible_on_transaction', 1)
            ->whereBetween('created_at', [date($startDate), date($endDate)])
            ->whereHas('getCart', function ($query) {
                $query->where('total_price', '>', 0);
              })
            ->orderBy('created_at', 'ASC')
            ->get();

        $dataJson = $this->generateAbandonCheckoutData($data, $startDate, $endDate);

        return response()->json($dataJson);
    }

    public function averageOrder($startDate, $endDate)
    {
        $data = PembelianCourse::where('status_pembayaran', 3)
            ->whereBetween('created_at', [date($startDate), date($endDate)])
            ->whereHas('getCart', function ($query) {
                $query->where('total_price', '>', 0);
            })
            ->orderBy('created_at', 'ASC')
            ->get();

        $dataJson = $this->generateAverageTotalCartData($data, $startDate, $endDate);

        return response()->json($dataJson);
    }

    public function totalTransaction($startDate, $endDate)
    {
        $data = PembelianCourse::where('status_pembayaran', 3)
            ->whereBetween('created_at', [date($startDate), date($endDate)])
            ->whereHas('getCart', function ($query) {
                $query->where('total_price', '>', 0);
            })
            ->orderBy('created_at', 'ASC')
            ->get();

        $dataJson = $this->generateCountedData($data, $startDate, $endDate);

        return response()->json($dataJson);
    }

    public function paidUser($startDate, $endDate)
    {
        $data = PembelianCourse::where('status_pembayaran', 3)
            ->whereBetween('created_at', [date($startDate), date($endDate)])
            ->whereHas('getCart', function ($query) {
                $query->where('total_price', '>', 0);
            })
            ->orderBy('created_at', 'ASC')
            ->get();

        $dataJson = $this->generateCountedData($data, $startDate, $endDate);

        return response()->json($dataJson);
    }

}

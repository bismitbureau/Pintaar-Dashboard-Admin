<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\CarbonPeriod;
use App\Models\User;
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

    public function totalUser($startDate, $endDate)
    {
      $data = User::whereBetween('created_at', [date($startDate), date($endDate)])
        ->orderBy('created_at', 'ASC')
        ->get();

      $dataJson = [];
      $previous_date = $data->first()->created_at->format('Y-m-d');
      $count = 0;
      foreach ($data as $this_data)
      {
          $this_date = $this_data->created_at->format('Y-m-d');
          if ($this_date != $previous_date) {

              $dataJson[] = [date("D, d M Y", strtotime($previous_date)), $count];

              $newUndefinedDateJson = [];
              $period = CarbonPeriod::create($previous_date, $this_date);
              foreach ($period as $date) {
                $newUndefinedDateJson[] = [$date->format('D, d M Y'), 0];
              }

              array_shift($newUndefinedDateJson);
              array_pop($newUndefinedDateJson);
              $dataJson = array_merge($dataJson, $newUndefinedDateJson);

              $previous_date = $this_date;
              $count = 0;
          }
          $count += 1;
      }
      return response()->json($dataJson);
    }
}

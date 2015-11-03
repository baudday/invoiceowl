<?php

namespace App\Lib;

use App\Invoice;

class Reporter {

  public static function invoices($days)
  {
    $ret = [];
    $now = new \DateTime("$days days ago");
    $interval = new \DateInterval("P1D");
    $period = new \DatePeriod($now, $interval, $days);
    foreach ($period as $day) {
      $key = $day->format('l');
      $ret[$key] = Invoice::where('sent_date', $day->format('Y-m-d'))->count();
    }
    return $ret;
  }

}

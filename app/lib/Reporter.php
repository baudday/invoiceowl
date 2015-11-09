<?php

namespace App\Lib;

use App\Invoice;
use App\User;
use App\Client;

class Reporter {

  private $days;

  public function __construct($days)
  {
    $this->days = $days;
    $this->now = new \DateTime("$days days ago", new \DateTimeZone('America/Chicago'));
    $this->interval = new \DateInterval("P1D");
    $this->period = new \DatePeriod($this->now, $this->interval, $days);
  }

  public function invoices()
  {
    $ret = [];
    foreach ($this->period as $day) {
      $key = $day->format('l');
      $ret[$key] = Invoice::where('sent_date', $day)->count();
    }
    return $ret;
  }

  public function users()
  {
    $ret = [];
    foreach ($this->period as $day) {
      $key = $day->format('l');
      $ret[$key] = User::whereRaw('date(created_at) <= ?', [$day->format('Y-m-d')])->count();
    }
    return $ret;
  }

  public function clients()
  {
    $ret = [];
    foreach ($this->period as $day) {
      $key = $day->format('l');
      $ret[$key] = Client::whereRaw('date(created_at) <= ?', [$day->format('Y-m-d')])->count();
    }
    return $ret;
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = [
        'month' => [
          'sent_count' => $this->userInvoices()->month('sent_date')->count(),
          'paid_count' => $this->userInvoices()->month('sent_date')->paid()->count(),
          'collected'  => $this->userInvoices()->paid()->month('sent_date')->sum('total')
        ],
        'all_time' => [
          'sent_count' => $this->userInvoices()->count(),
          'paid_count' => $this->userInvoices()->paid()->count(),
          'collected'  => $this->userInvoices()->paid()->sum('total'),
          'unpaid_count' => $this->userInvoices()->unpaid()->count(),
          'past_due_count' => $this->userInvoices()->pastDue()->count(),
          'uncollected' => $this->userInvoices()->unpaid()->sum('total')
        ],
        'pastDueInvoices' => $this->userInvoices()->pastDue()->get()
      ];

      return view('dashboard', $data);
    }
}

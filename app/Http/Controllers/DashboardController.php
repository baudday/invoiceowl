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
          'sent_count' => $this->userInvoices()->published()->month('sent_date')->count(),
          'paid_count' => $this->userInvoices()->published()->month('sent_date')->paid()->count(),
          'collected'  => $this->userInvoices()->published()->paid()->month('updated_at')->sum('total')
        ],
        'all_time' => [
          'sent_count' => $this->userInvoices()->published()->count(),
          'paid_count' => $this->userInvoices()->published()->paid()->count(),
          'collected'  => $this->userInvoices()->published()->paid()->sum('total'),
          'unpaid_count' => $this->userInvoices()->published()->unpaid()->count(),
          'past_due_count' => $this->userInvoices()->published()->pastDue()->count(),
          'uncollected' => $this->userInvoices()->published()->unpaid()->sum('total')
        ],
        'pastDueInvoices' => $this->userInvoices()->published()->pastDue()->get()
      ];

      return view('dashboard', $data);
    }
}

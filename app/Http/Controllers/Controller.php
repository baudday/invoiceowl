<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function user()
    {
      return \Auth::user();
    }

    public function userClients()
    {
      return $this->user()->clients();
    }

    public function userInvoices()
    {
      return $this->user()->invoices()->with('client')->published();
    }

    public function userClientInvoices($client_id)
    {
      return $this->userClients()->findOrFail($client_id)->invoices()->published();
    }
}

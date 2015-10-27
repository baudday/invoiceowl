<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Invoice;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $invoices = $this->userInvoices()->with('client')->published()->unpaid()->orderBy('due_date', 'desc')->get();
        return view('invoices/index', compact('invoices'));
    }
}
<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InvoicesTest extends TestCase
{

  use DatabaseTransactions;

  public function test_it_displays_the_create_form_correctly()
  {
    $user = $this->userWithClient();
    $client = $user->clients()->first();

    $this->actingAs($user)
         ->visit("/dashboard/clients/$client->id/invoices/create")
         ->see("Invoice $client->name")
         ->assertViewHas('owl_id', $client->invoices()->published()->count() + 1);
  }

  // TODO: Need to figure out a way to test template preview
  public function test_it_stubs_out_an_invoice_and_accurately_calculates_total()
  {
    $user = $this->userWithClient();
    $client = $user->clients()->first();
    $invoice = factory(App\Invoice::class, 'stub')->make();
    $lineItems = factory(App\LineItem::class, 3)->make();
    $taxItems = factory(App\TaxItem::class, 3)->make();
    $items = [];
    $quantities = [];
    $prices = [];
    $taxes = [];
    $percentages = [];
    $subtotal = 0;
    $total = 0;

    $lineItems->each(function ($item) use (&$items, &$quantities, &$prices, &$subtotal) {
      $items[] = $item->description;
      $quantities[] = $item->quantity;
      $prices[] = $item->unit_price;
      $subtotal += $item->totalPrice();
    });

    $total = $subtotal;

    $taxItems->each(function ($item) use (&$taxes, &$percentages) {
      $taxes[] = $item->description;
      $percentages[] = $item->percentage;
    });

    $template = App\Template::first();
    $qs = http_build_query(array_merge($invoice->toArray(), compact('items', 'quantities', 'prices', 'taxes', 'percentages')));

    $this->actingAs($user)
         ->get("/api/v1/clients/$client->id/templates/$template->id?$qs")
         ->seeInDatabase('invoices', $invoice->toArray())
         ->seeJson([
           'invoice_id' => App\Invoice::where('client_id', $client->id)->orderBy('created_at', 'desc')->first()->id
         ]);

    $new_invoice = App\Invoice::where('client_id', $client->id)->orderBy('created_at', 'desc')->first();

    $lineItems->each(function ($item) {
      $this->seeInDatabase('line_items', $item->toArray());
    });

    $taxItems->each(function ($item) {
      $this->seeInDatabase('tax_items', $item->toArray());
    });

    foreach($new_invoice->taxItems as $item) {
      $total += $item->totalPrice();
    };

    $this->assertEquals(number_format($new_invoice->subtotal, 2), number_format($subtotal, 2));
    $this->assertEquals(number_format($new_invoice->total, 2), number_format($total, 2));
  }

  public function test_it_displays_unpaid_invoices()
  {
    $user = $this->userWithClientAndInvoices();
    $invoice = $user->invoices()->first();
    $client = $invoice->client()->first();

    $this->actingAs($user)
         ->visit('/dashboard/invoices')
         ->see($client->name)
         ->see($invoice->description)
         ->see(date('F d, Y', strtotime($invoice->sent_date)))
         ->see(date('F d, Y', strtotime($invoice->due_date)))
         ->see($invoice->total);
  }

  public function test_it_marks_an_invoice_as_paid()
  {
    $user = $this->userWithClientAndInvoices([], [], 1);
    $invoice = $user->invoices()->first();

    $this->actingAs($user)
         ->visit('/dashboard/invoices')
         ->see($invoice->description)
         ->see('Paid')
         ->press('Paid')
         ->seePageIs('/dashboard/invoices')
         ->dontSee($invoice->description);
  }

  public function test_it_doesnt_display_paid_invoices()
  {
    $user = $this->userWithClientAndInvoices(['paid' => true]);
    $invoice = $user->invoices()->first();
    $client = $invoice->client()->first();

    $this->actingAs($user)
         ->visit('/dashboard/invoices')
         ->dontSee($invoice->description);
  }

  public function test_it_doesnt_display_another_users_invoices()
  {
    $user1 = $this->userWithClientAndInvoices();
    $user2 = $this->userWithClientAndInvoices();

    $this->actingAs($user1)
         ->visit('/dashboard/invoices')
         ->see($user1->invoices()->first()->description)
         ->dontSee($user2->invoices()->first()->description);
  }

  public function test_it_displays_all_past_invoices_for_a_client()
  {
    $user = $this->userWithClientAndInvoices();
    $client = $user->clients()->first();
    $client->invoices()->first()->update(['paid' => true]);
    $invoices = $client->invoices()->get();

    $this->actingAs($user)
         ->visit("/dashboard/clients/$client->id");

    $invoices->each(function($invoice) {
      $this->see($invoice->description);
    });
  }
}

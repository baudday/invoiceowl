<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClientsTest extends TestCase
{

  use DatabaseTransactions;

  public function test_it_creates_a_client()
  {
    $user = factory(App\User::class)->create();
    $client = factory(App\Client::class)->make();
    $address = factory(App\Address::class)->make();

    $this->actingAs($user)
         ->visit('/dashboard/clients')
         ->click('New Client')
         ->seePageIs('/dashboard/clients/create')
         ->type($client->name, 'name')
         ->type($client->email, 'email')
         ->type($address->line_one, 'line_one')
         ->type($address->line_two, 'line_two')
         ->type($address->city, 'city')
         ->type($address->state, 'state')
         ->type($address->zip, 'zip')
         ->type($address->country, 'country')
         ->press('Save')
         ->seePageIs(sprintf('/dashboard/clients/%d', $user->clients()->first()->id))
         ->seeInDatabase('clients', $client->toArray())
         ->seeInDatabase('addresses', array_merge($address->toArray(), ['user_id' => null, 'client_id' => $user->clients()->first()->id]))
         ->see($client->name)
         ->see($client->email);
  }

  public function test_it_edits_a_client()
  {
    $user = $this->userWithClient();
    $client = $user->clients()->first();
    $address = factory(App\Address::class)->make();

    $this->actingAs($user)
         ->visit('/dashboard/clients')
         ->see($client->name)
         ->click('Edit')
         ->seePageIs("/dashboard/clients/$client->id/edit")
         ->type("New Name", 'name')
         ->type('new@example.com', 'email')
         ->type($address->line_one, 'line_one')
         ->type($address->line_two, 'line_two')
         ->type($address->city, 'city')
         ->type($address->state, 'state')
         ->type($address->zip, 'zip')
         ->type($address->country, 'country')
         ->press('Update')
         ->seePageIs("/dashboard/clients/$client->id/edit")
         ->see("New Name")
         ->see("new@example.com")
         ->see($address->line_one)
         ->see($address->line_two)
         ->see($address->city)
         ->see($address->state)
         ->see($address->zip)
         ->see($address->country);
  }

  public function test_it_deletes_a_client()
  {
    $user = $this->userWithClient();
    $client = $user->clients()->first();

    $this->actingAs($user)
         ->visit('/dashboard/clients')
         ->see($client->name)
         ->press('Delete')
         ->seePageIs('/dashboard/clients')
         ->dontSee($client->name);
  }

  public function test_it_displays_all_past_invoices_on_client_show()
  {
    $user = $this->userWithClientAndInvoices();
    $client = $user->clients()->first();
    $invoice = $client->invoices()->first();

    $this->actingAs($user)
         ->visit("/dashboard/clients/$client->id")
         ->see($client->name)
         ->see($invoice->description)
         ->see($invoice->total);
  }

  public function test_it_doesnt_display_unpublished_invoices_on_client_show()
  {
    $user = $this->userWithClientAndInvoices(['published' => false]);
    $client = $user->clients()->first();
    $invoice = $client->invoices()->first();

    $this->actingAs($user)
         ->visit("/dashboard/clients/$client->id")
         ->see($client->name)
         ->dontSee($invoice->description);
  }

  public function test_it_doesnt_display_other_users_clients()
  {
    $user1 = $this->userWithClient();
    $user2 = $this->userWithClient();

    $this->actingAs($user1)
         ->visit('/dashboard/clients')
         ->see($user1->clients()->first()->name)
         ->dontSee($user2->clients()->first()->name);
  }

  public function test_it_doesnt_find_other_users_client()
  {
    $user1 = $this->userWithClient();
    $user2 = $this->userWithClient();
    $client1 = $user1->clients()->first();
    $client2 = $user2->clients()->first();

    $this->actingAs($user1)
         ->call('GET', "/dashboard/clients/$client2->id");
    $this->assertResponseStatus(404);
  }
}

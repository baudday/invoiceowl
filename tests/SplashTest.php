<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SplashTest extends TestCase
{

  use DatabaseTransactions;

  public function test_it_saves_email_to_database()
  {
    $email = factory(App\Email::class)->make();

    $this->visit('/')
         ->see('InvoiceOwl')
         ->type($email->email, '#email')
         ->press('email_submit')
         ->seePageIs('/')
         ->see("Thanks! We'll send you an invite as soon as one becomes available.")
         ->seeInDatabase('emails', $email->toArray());
  }

  public function test_it_saves_contact_request_to_database()
  {
    $contact = factory(App\Contact::class)->make();

    $this->visit('/')
         ->see('InvoiceOwl')
         ->type($contact->email, '#contact_email')
         ->type($contact->message, '#message')
         ->press('contact_submit')
         ->seePageIs('/')
         ->see("Thanks! We'll be in touch soon. Don't forget to request early access!")
         ->seeInDatabase('contacts', $contact->toArray());
  }
}

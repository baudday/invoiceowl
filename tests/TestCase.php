<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function userWithClient($userOverrides = [])
    {
      $user = factory(App\User::class)->create();
      $user->clients()->save(factory(App\Client::class)->make());
      return $user;
    }

    public function userWithClientAndInvoices($invoiceOverrides = [], $userOverrides = [], $invoiceCount = 3)
    {
      $user = $this->userWithClient($userOverrides);
      $client = $user->clients()->first();
      if ($invoiceCount > 1) {
        factory(App\Invoice::class, $invoiceCount)->create($invoiceOverrides)->each(function ($invoice) use ($client, $user) {
          $client->invoices()->save($invoice);
          $user->invoices()->save($invoice);
        });
      }
      else {
        $invoice = factory(App\Invoice::class)->create($invoiceOverrides);
        $client->invoices()->save($invoice);
        $user->invoices()->save($invoice);
      }
      return $user;
    }
}

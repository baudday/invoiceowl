<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{

  use DatabaseTransactions;

  public function test_it_doesnt_register_uninvited_user()
  {
    $this->visit('/auth/register')
         ->seePageIs('/');
  }

  public function test_it_registers_invited_user()
  {
    $invite = factory(App\Email::class, 'invite')->create();
    $user = factory(App\User::class)->make();

    $this->visit("/auth/register?email=$invite->email&key=$invite->key")
         ->see('Register')
         ->type($user->name, 'name')
         ->type($user->company_name, 'company_name')
         ->type($user->email, 'email')
         ->type($user->password, 'password')
         ->type($user->password, 'password_confirmation')
         ->press('Register')
         ->seePageIs('/dashboard')
         ->dontSee('Templates')
         ->dontSee('Admin');
  }

  public function test_it_doesnt_login_unregistered_user()
  {
    $this->visit("/auth/login")
         ->see('Sign In')
         ->type('junk@junk.com', 'email')
         ->type('password', 'password')
         ->press('Sign In')
         ->seePageIs('/auth/login')
         ->see('These credentials do not match our records.');
  }

  public function test_it_logs_in_registered_user()
  {
    $user = factory(App\User::class)->create(['password' => bcrypt('password')]);
    $this->visit('/auth/login')
         ->see('Sign In')
         ->type($user->email, 'email')
         ->type('password', 'password')
         ->press('Sign In')
         ->seePageIs('/dashboard')
         ->see(sprintf("Welcome %s!", $user->company_name ?: $user->name));
  }

  public function test_it_doesnt_allow_regular_user_admin_access()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user)
         ->visit('/admin')
         ->seePageIs('/dashboard');
  }

  public function test_it_allows_admin_user_admin_access()
  {
    $user = factory(App\User::class, 'admin')->create();

    $this->actingAs($user)
         ->visit('/admin')
         ->seePageIs('/admin');
  }

  public function test_it_logs_user_out()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user)
         ->visit('/dashboard')
         ->seePageIs('/dashboard')
         ->click('Logout')
         ->seePageIs('/')
         ->visit('/dashboard')
         ->seePageIs('/auth/login');
  }
}

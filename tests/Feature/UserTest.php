<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_admin_redirect_to_admin_dashboard_successfully()
    {
        $response = $this->post('/', [
            'email' => 'library@neu.edu.ph',
            'password' => 'secret'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/library');
    }

    public function test_login_staff_redirect_to_staff_dashboard_successfully()
    {
        $response = $this->post('/', [
            'email' => 'danna.castro@neu.edu.ph',
            'password' => 'secret'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/staff');
    }

    public function test_login_student_redirect_to_student_dashboard_successfully()
    {
        $response = $this->post('/', [
            'email' => 'roger.sese@neu.edu.ph',
            'password' => 'secret'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/archives');
    }

   public function test_unauthorized_user_cannot_access_dashboard()
   {
       $response = $this->get('/archives');
       $response->assertStatus(302);
       $response->assertRedirect('/');
   }

   public function test_student_cannot_access_staff_dashboard()
   {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('/staff');
        $response->assertForbidden();
   }

   public function test_student_cannot_access_admin_dashboard()
   {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('/library');
        $response->assertForbidden();
   }

   public function test_staff_cannot_access_admin_dashboard()
   {
        $user = User::find(3);
        $response = $this->actingAs($user)->get('/library');
        $response->assertForbidden();
   }

   public function test_request_page_not_found()
   {
       $response = $this->get('/malicious');
       $response->assertNotFound();
   }
}

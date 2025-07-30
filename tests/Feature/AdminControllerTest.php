<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ShortLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function non_admin_cannot_access_dashboard()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    /** @test */
    public function test_admin_can_delete_a_link()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $link = ShortLink::factory()->create();
    
        $response = $this->actingAs($admin)->delete(route('link.delete', ['id' => $link->id]));
    
        $response->assertRedirect(); // You can also add ->assertStatus(302) if needed
        $this->assertDatabaseMissing('short_links', ['id' => $link->id]);
    }
    

    /** @test */
    public function guest_cannot_access_admin_routes()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function a_user_can_delete_their_own_link()
    {
        // Create a user and a short link that belongs to them
        $user = User::factory()->create();
        $link = ShortLink::factory()->create(['user_id' => $user->id]);

        // Act as the user and send a DELETE request to the user route
        $response = $this->actingAs($user)->delete(route('user.link.delete', ['id' => $link->id]));

        // Assert the user is redirected and the link is deleted
        $response->assertRedirect();
        $this->assertDatabaseMissing('short_links', ['id' => $link->id]);
    }

    public function a_user_cannot_delete_others_links()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $link = ShortLink::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->delete(route('user.link.delete', ['id' => $link->id]));

        $response->assertForbidden(); // 403
        $this->assertDatabaseHas('short_links', ['id' => $link->id]);
    }

}


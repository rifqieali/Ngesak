<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudAndDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_dashboard_with_totals(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'user_id' => $user->id,
            'type' => 'penghasilan',
            'name' => 'Gaji',
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'penghasilan',
            'amount' => 5000000,
            'transaction_date' => '2026-07-29',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('5.000.000');
    }

    public function test_user_can_crud_category(): void
    {
        $user = User::factory()->create();

        // Create
        $response = $this->actingAs($user)->post('/categories', [
            'name' => 'Makan & Minum',
            'type' => 'pengeluaran',
        ]);
        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Makan & Minum', 'user_id' => $user->id]);

        $category = Category::where('user_id', $user->id)->first();

        // Read Index
        $response = $this->actingAs($user)->get('/categories');
        $response->assertStatus(200);
        $response->assertSee('Makan & Minum');

        // Update
        $response = $this->actingAs($user)->put("/categories/{$category->id}", [
            'name' => 'Kuliner',
            'type' => 'pengeluaran',
        ]);
        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Kuliner', 'id' => $category->id]);

        // Delete
        $response = $this->actingAs($user)->delete("/categories/{$category->id}");
        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_user_can_crud_transaction(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'user_id' => $user->id,
            'type' => 'pengeluaran',
            'name' => 'Transport',
        ]);

        // Create
        $response = $this->actingAs($user)->post('/transactions', [
            'transaction_date' => '2026-07-29',
            'type' => 'pengeluaran',
            'category_id' => $category->id,
            'amount' => 25000,
            'notes' => 'Bensin motor',
        ]);
        $response->assertRedirect('/transactions');
        $this->assertDatabaseHas('transactions', ['amount' => 25000, 'user_id' => $user->id]);

        $tx = Transaction::where('user_id', $user->id)->first();

        // Read Index
        $response = $this->actingAs($user)->get('/transactions');
        $response->assertStatus(200);
        $response->assertSee('Bensin motor');

        // Update
        $response = $this->actingAs($user)->put("/transactions/{$tx->id}", [
            'transaction_date' => '2026-07-29',
            'type' => 'pengeluaran',
            'category_id' => $category->id,
            'amount' => 30000,
            'notes' => 'Bensin mobil',
        ]);
        $response->assertRedirect('/transactions');
        $this->assertDatabaseHas('transactions', ['amount' => 30000, 'notes' => 'Bensin mobil']);

        // Delete
        $response = $this->actingAs($user)->delete("/transactions/{$tx->id}");
        $response->assertRedirect('/transactions');
        $this->assertDatabaseMissing('transactions', ['id' => $tx->id]);
    }

    public function test_user_cannot_access_other_users_data(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $categoryA = Category::create([
            'user_id' => $userA->id,
            'type' => 'pengeluaran',
            'name' => 'Privat User A',
        ]);

        // User B tries to edit User A's category -> 403 Forbidden
        $response = $this->actingAs($userB)->get("/categories/{$categoryA->id}/edit");
        $response->assertStatus(403);
    }
}

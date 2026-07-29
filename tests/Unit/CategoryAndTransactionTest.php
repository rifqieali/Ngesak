<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryAndTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_and_transaction_relationships(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'user_id' => $user->id,
            'type' => 'pengeluaran',
            'name' => 'Makan & Minum',
        ]);

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'pengeluaran',
            'amount' => 50000.00,
            'transaction_date' => '2026-07-29',
            'notes' => 'Makan siang',
        ]);

        $this->assertEquals($user->id, $category->user->id);
        $this->assertCount(1, $user->categories);

        $this->assertEquals($user->id, $transaction->user->id);
        $this->assertEquals($category->id, $transaction->category->id);
        $this->assertCount(1, $user->transactions);
        $this->assertCount(1, $category->transactions);
    }
}

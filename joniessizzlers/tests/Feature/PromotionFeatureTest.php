<?php

namespace Tests\Feature;

use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PromotionFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_promotions_admin_requires_password(): void
    {
        $this->get('/admin/promotions')->assertRedirect('/admin/login');
    }

    public function test_public_promotion_details_page_loads(): void
    {
        $promotion = Promotion::create([
            'title' => 'Student Special',
            'description' => 'Save on your sizzling favorites.',
            'image_path' => 'promotions/student-special.jpg',
        ]);

        $this->get('/promotions/' . $promotion->id)
            ->assertOk()
            ->assertSeeText('Student Special')
            ->assertSeeText('Save on your sizzling favorites.');
    }

    public function test_admin_can_create_and_edit_a_promotion(): void
    {
        Storage::fake('public');

        $this->withSession(['admin_logged_in' => true])
            ->post('/admin/promotions', [
                'title' => 'Family Feast',
                'description' => 'A generous meal for sharing.',
                'image' => UploadedFile::fake()->create('family-feast.jpg', 100, 'image/jpeg'),
            ])
            ->assertRedirect('/admin/promotions');

        $promotion = Promotion::firstOrFail();
        $this->assertSame('Family Feast', $promotion->title);
        $this->assertTrue(Storage::disk('public')->exists($promotion->image_path));

        $this->withSession(['admin_logged_in' => true])
            ->put('/admin/promotions/' . $promotion->id, [
                'title' => 'Updated Family Feast',
                'description' => 'Updated description.',
                'image' => UploadedFile::fake()->create('updated-feast.png', 100, 'image/png'),
            ])
            ->assertRedirect('/admin/promotions');

        $this->assertSame('Updated Family Feast', $promotion->fresh()->title);
    }

    public function test_admin_can_delete_a_promotion(): void
    {
        Storage::fake('public');
        $imagePath = UploadedFile::fake()->create('promotion.jpg', 100, 'image/jpeg')->store('promotions', 'public');
        $promotion = Promotion::create([
            'title' => 'Weekend Special',
            'description' => 'A weekend treat.',
            'image_path' => $imagePath,
        ]);

        $this->withSession(['admin_logged_in' => true])
            ->delete('/admin/promotions/' . $promotion->id)
            ->assertRedirect('/admin/promotions');

        $this->assertDatabaseMissing('promotions', ['id' => $promotion->id]);
        $this->assertFalse(Storage::disk('public')->exists($imagePath));
    }
}
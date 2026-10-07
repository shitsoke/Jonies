<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_view_link_opens_the_selected_food_details(): void
    {
        $menuItem = MenuItem::create([
            'title' => 'Flaming Bellybuster',
            'category' => 'all-time-favorites',
            'description' => 'A sizzling plate packed with bold flavor.',
            'price' => 500,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee(route('menu-items.show', $menuItem))
            ->assertDontSee('>VIEW</a>', false);

        $this->get(route('menu-items.show', $menuItem))
            ->assertOk()
            ->assertSee('Flaming Bellybuster')
            ->assertSee('A sizzling plate packed with bold flavor.')
            ->assertSee('₱500.00');
    }
}

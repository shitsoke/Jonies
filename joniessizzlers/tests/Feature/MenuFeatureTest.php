<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_page_can_show_a_selected_category(): void
    {
        MenuItem::create([
            'title' => 'Mango Sago',
            'category' => 'dessert',
            'description' => 'Cold sweet dessert.',
            'price' => '129.00',
            'image_path' => 'menu-items/mango-sago.jpg',
        ]);

        MenuItem::create([
            'title' => 'Crispy Calamari',
            'category' => 'seafoods',
            'description' => 'Golden fried squid.',
            'price' => '199.00',
            'image_path' => 'menu-items/calamari.jpg',
        ]);

        $response = $this->get('/menu?category=dessert');

        $response->assertOk();
        $response->assertSeeText('Dessert');
        $response->assertSee('Mango Sago');
        $response->assertDontSee('Crispy Calamari');
    }

    public function test_admin_menu_requires_password(): void
    {
        $response = $this->from('/')->get('/admin/menu');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_login_page_loads(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
        $response->assertSeeText('Enter Password');
    }
}

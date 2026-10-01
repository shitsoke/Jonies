<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteContentFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_content_page_requires_password(): void
    {
        $response = $this->get('/admin/content');

        $response->assertRedirect('/admin/login');
    }

    public function test_content_page_loads_after_login(): void
    {
        $this->withSession(['admin_logged_in' => true])
            ->get('/admin/content')
            ->assertOk()
            ->assertSeeText('Website Content');
    }

    public function test_default_content_fields_are_available_for_each_page(): void
    {
        $this->withSession(['admin_logged_in' => true])
            ->get('/admin/content')
            ->assertOk()
            ->assertSee('name="content[home][main_title][label]"', false)
            ->assertSee('name="content[home][subtitle][label]"', false)
            ->assertSee('name="content[about][main_title][label]"', false)
            ->assertSee('name="content[location][main_title][label]"', false);
    }

    public function test_edits_to_content_are_shown_on_the_public_page(): void
    {
        $this->withSession(['admin_logged_in' => true])
            ->post('/admin/content', [
                'content' => [
                    'home' => [
                        'main_title' => [
                            'label' => 'Main title',
                            'value' => 'Updated home title',
                            'sort_order' => 0,
                        ],
                    ],
                ],
            ])
            ->assertRedirect('/admin/content');

        $response = $this->get('/');

        $response->assertOk()->assertSee('Updated home title');
    }
}

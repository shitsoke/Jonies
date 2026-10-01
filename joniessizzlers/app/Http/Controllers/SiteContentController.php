<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteContentController extends Controller
{
    public function adminIndex(Request $request)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $pages = [
            'home' => 'Home',
            'about' => 'About',
            'location' => 'Location',
            'careers' => 'Careers',
            'contact' => 'Get in Touch',
        ];

        $content = [];
        foreach ($pages as $slug => $label) {
            $entries = SiteContent::where('page', $slug)->orderBy('sort_order')->orderBy('id')->get();
            $content[$slug] = $this->buildEntriesForPage($slug, $entries);
        }

        return view('admin.content', [
            'pages' => $pages,
            'content' => $content,
        ]);
    }

    public function save(Request $request)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'content' => ['nullable', 'array'],
            'content.*' => ['array'],
            'content.*.*' => ['array'],
            'content.*.*.label' => ['nullable', 'string', 'max:255'],
            'content.*.*.value' => ['nullable', 'string', 'max:10000'],
            'content.*.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'content.*.*.delete' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['array'],
            'images.*.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $payload = $request->input('content', []);
        $allowedPages = ['home', 'about', 'location', 'careers', 'contact'];
        $allowedKeys = [
            'home' => ['main_title', 'subtitle', 'hero_image', 'hero_image_2', 'hero_image_3', 'lead_text', 'supporting_text'],
            'about' => ['main_title', 'paragraph_1', 'paragraph_2', 'paragraph_3'],
            'location' => ['main_title', 'intro'],
            'careers' => ['main_title', 'subtitle', 'intro', 'body'],
            'contact' => ['main_title', 'description'],
        ];

        foreach ($payload as $page => $items) {
            if (!in_array($page, $allowedPages, true)) {
                continue;
            }

            foreach ($items as $key => $entry) {
                if (!in_array($key, $allowedKeys[$page], true)) {
                    continue;
                }

                $delete = (bool) ($entry['delete'] ?? false);
                $value = $entry['value'] ?? '';

                // Handle Image File Uploads
                $file = $request->file("images.$page.$key");
                if ($file) {
                    if ($file->isValid()) {
                        // Delete previous uploaded file from public disk if it exists
                        $existing = SiteContent::where('page', $page)->where('key', $key)->first();
                        if ($existing && $existing->value && Storage::disk('public')->exists($existing->value)) {
                            Storage::disk('public')->delete($existing->value);
                        }

                        // Store new image in 'storage/app/public/content'
                        $value = $file->store('content', 'public');
                    }
                }

                if ($delete || (trim((string) ($entry['label'] ?? '')) === '' && trim((string) $value) === '')) {
                    // Remove file from storage on delete
                    $existing = SiteContent::where('page', $page)->where('key', $key)->first();
                    if ($existing && $existing->value && Storage::disk('public')->exists($existing->value)) {
                        Storage::disk('public')->delete($existing->value);
                    }

                    SiteContent::where('page', $page)->where('key', $key)->delete();
                    continue;
                }

                SiteContent::updateOrCreate(
                    ['page' => $page, 'key' => $key],
                    [
                        'label' => $entry['label'] ?? 'Content',
                        'value' => $value,
                        'sort_order' => (int) ($entry['sort_order'] ?? 0),
                    ]
                );
            }
        }

        return redirect()->route('admin.content')->with('success', 'Website content updated successfully.');
    }

    private function buildEntriesForPage(string $page, $existingEntries)
    {
        $defaults = [
            'home' => [
                'main_title' => 'Have a',
                'subtitle' => 'Sizzling Day!',
                'hero_image' => 'images/homeImage 1.jpg',
                'hero_image_2' => 'images/homeImage 2.jpg',
                'hero_image_3' => 'images/homeImage 3.jpg',
                'lead_text' => 'Serving Cebu\'s favorite sizzling home-style plates and roasted specialties for 25 years.',
                'supporting_text' => 'Experience the ultimate Filipino comfort food experience. From our iconic table-side flaming chicken to smoking-hot iron plates packed with savory goodness, we serve up bold flavors that bring people together.',
            ],
            'about' => [
                'main_title' => 'Turning Everyday Dining into a Feast',
                'paragraph_1' => 'Born in Cebu, Jonies Sizzlers & Roast has spent years mastering the art of the perfect sizzle.',
                'paragraph_2' => 'We specialize in hot, smoking sizzling plates, slow-cooked roasts, and our signature theatrical "flaming" dishes that turn a simple meal into an unforgettable dining experience.',
                'paragraph_3' => 'We believe that great food shouldn\'t cost a fortune. Whether you are gathered for a family reunion, catching up with friends, or grabbing a quick lunch break, our vibrant, clean, and welcoming spaces are designed to make you feel right at home. Come for the aroma, stay for the taste, and leave with a smile.',
            ],
            'location' => [
                'main_title' => 'VISIT US',
                'intro' => 'Drop by for a dine-in experience, or grab your favorites for takeout.',
            ],
            'careers' => [
                'main_title' => 'JOIN THE JONIES SIZZLERS',
                'subtitle' => '& ROAST TEAM',
                'intro' => 'At Jonies, our secret ingredient isn\'t just our recipe—it\'s our people. We pride ourselves on a customer-oriented, high-energy environment where every team member greets our guests with a genuine smile.',
                'body' => 'We are constantly looking for passionate talent to join our growing kitchen crew, service staff, and branch management teams. If your local food and thrive in a fast-paced environment, we want to meet you.',
            ],
            'contact' => [
                'main_title' => 'We would love to hear from you.',
                'description' => 'Reach out for reservations, catering, events, or simply to say hello.',
            ],
        ];

        $entries = collect();
        foreach ($defaults[$page] ?? [] as $key => $value) {
            $saved = $existingEntries->firstWhere('key', $key);
            $entries->push((object) [
                'key' => $key,
                'label' => ucfirst(str_replace('_', ' ', $key)),
                'value' => $saved?->value ?? $value,
                'sort_order' => $saved?->sort_order ?? 0,
            ]);
        }

        return $entries;
    }
}
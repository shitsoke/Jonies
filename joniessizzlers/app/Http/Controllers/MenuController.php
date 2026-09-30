<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    private function getCategories(): array
    {
        return [
            'all-time-favorites' => 'All time favorites',
            'house-of-specialties' => 'House of Specialties',
            'seafoods' => 'Seafoods',
            'dessert' => 'Dessert',
            'shareable-flaming-bundles' => 'Shareable Flaming Bundles',
        ];
    }

    public function showFeatured(string $slug)
    {
        $featuredFoods = [
            'all-time-favorites' => [
                'title' => 'All-Time Favorites',
                'description' => 'Juicy, sizzling plates made for your everyday cravings. Enjoy the comforting Jonies flavors that keep guests coming back.',
                'price' => 'From ₱299',
                'image' => 'images/All time favorites.jpg',
                'category' => 'all-time-favorites',
            ],
            'house-specialties' => [
                'title' => 'House Specialties',
                'description' => 'Signature flavors with a little extra Jonies magic, prepared hot and ready to make your meal memorable.',
                'price' => 'From ₱349',
                'image' => 'images/House of Specialties.png',
                'category' => 'house-of-specialties',
            ],
            'fresh-seafood' => [
                'title' => 'Fresh Seafood',
                'description' => 'Flavor-packed seafood favorites grilled to perfection and served hot with the sides you love.',
                'price' => 'From ₱399',
                'image' => 'images/Seafood.png',
                'category' => 'seafoods',
            ],
        ];

        abort_unless(isset($featuredFoods[$slug]), 404);

        return view('food-detail', ['food' => $featuredFoods[$slug]]);
    }

    public function adminLoginForm()
    {
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        $password = $request->input('password');
        $expected = 'joniesadmin2026';

        if ($password !== $expected) {
            return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
        }

        $request->session()->put('admin_logged_in', true);

        return redirect()->route('admin.menu');
    }

    public function adminLogout(Request $request)
    {
        $request->session()->forget('admin_logged_in');

        return redirect()->route('admin.login');
    }

    public function index(Request $request)
    {
        $selectedCategory = $request->query('category', 'all-time-favorites');
        $allCategories = $this->getCategories();

        $items = MenuItem::query()
            ->where('category', $selectedCategory)
            ->orderBy('title')
            ->get();

        if ($items->isEmpty() && in_array($selectedCategory, array_keys($allCategories), true)) {
            $items = MenuItem::query()->where('category', $selectedCategory)->get();
        }

        return view('menu', [
            'selectedCategory' => $selectedCategory,
            'categories' => $allCategories,
            'items' => $items,
        ]);
    }

    public function adminIndex(Request $request)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $items = MenuItem::latest()->get();

        return view('admin.menu', [
            'items' => $items,
            'categories' => $this->getCategories(),
            'editingItem' => null,
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu-items', 'public');
        }

        MenuItem::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.menu')->with('success', 'Menu item added successfully.');
    }

    public function edit(Request $request, MenuItem $menuItem)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.menu', [
            'items' => MenuItem::latest()->get(),
            'categories' => $this->getCategories(),
            'editingItem' => $menuItem,
        ]);
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($menuItem->image_path && Storage::disk('public')->exists($menuItem->image_path)) {
                Storage::disk('public')->delete($menuItem->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('menu-items', 'public');
        }

        $menuItem->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'image_path' => $validated['image_path'] ?? $menuItem->image_path,
        ]);

        return redirect()->route('admin.menu')->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Request $request, MenuItem $menuItem)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($menuItem->image_path && Storage::disk('public')->exists($menuItem->image_path)) {
            Storage::disk('public')->delete($menuItem->image_path);
        }

        $menuItem->delete();

        return redirect()->route('admin.menu')->with('success', 'Menu item deleted successfully.');
    }
}
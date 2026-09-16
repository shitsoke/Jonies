<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function show(Promotion $promotion)
    {
        return view('promotion', [
            'promotion' => $promotion,
        ]);
    }

    public function adminIndex(Request $request)
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.promotions', [
            'promotions' => Promotion::latest()->get(),
            'editingPromotion' => null,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        Promotion::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_path' => $request->file('image')->store('promotions', 'public'),
        ]);

        return redirect()->route('admin.promotions')->with('success', 'Promotion added successfully.');
    }

    public function edit(Request $request, Promotion $promotion)
    {
        $this->authorizeAdmin($request);

        return view('admin.promotions', [
            'promotions' => Promotion::latest()->get(),
            'editingPromotion' => $promotion,
        ]);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $imagePath = $promotion->image_path;
        if ($request->hasFile('image')) {
            $this->deleteStoredImage($promotion->image_path);
            $imagePath = $request->file('image')->store('promotions', 'public');
        }

        $promotion->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.promotions')->with('success', 'Promotion updated successfully.');
    }

    public function destroy(Request $request, Promotion $promotion)
    {
        $this->authorizeAdmin($request);
        $this->deleteStoredImage($promotion->image_path);
        $promotion->delete();

        return redirect()->route('admin.promotions')->with('success', 'Promotion deleted successfully.');
    }

    private function authorizeAdmin(Request $request): void
    {
        if (!$request->session()->get('admin_logged_in')) {
            abort(redirect()->route('admin.login'));
        }
    }

    private function deleteStoredImage(?string $imagePath): void
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
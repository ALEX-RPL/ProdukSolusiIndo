<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display catalog for public/user.
     */
    public function index(Request $request)
    {
        $query = Product::withCount('comments');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products  = $query->latest()->paginate(12)->appends($request->query());
        $categories = Product::distinct()->pluck('category')->filter();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display a single product with comments.
     */
    public function show(Product $product)
    {
        $product->load(['comments.user']);
        return view('products.show', compact('product'));
    }

    // ── Admin Methods ─────────────────────────────────────────────────

    /**
     * Admin dashboard with statistics.
     */
    public function adminDashboard()
    {
        $totalProducts = Product::count();
        $totalComments = Comment::count();
        $latestProducts = Product::latest()->take(5)->get();
        $latestComments = Comment::with(['user', 'product'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalComments', 'latestProducts', 'latestComments'
        ));
    }

    /**
     * Admin product listing.
     */
    public function adminIndex()
    {
        $products = Product::withCount('comments')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show form to create a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'category'    => ['required', 'string', 'max:100'],
            'stock'       => ['required', 'integer', 'min:0'],
            'photo'       => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $photoName = null;
        if ($request->hasFile('photo')) {
            $photo     = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('products', $photoName, 'public');
        }

        Product::create([
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'category'    => $validated['category'],
            'stock'       => $validated['stock'],
            'photo'       => $photoName,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show form to edit a product.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'category'    => ['required', 'string', 'max:100'],
            'stock'       => ['required', 'integer', 'min:0'],
            'photo'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $photoName = $product->photo;

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($product->photo) {
                Storage::disk('public')->delete('products/' . $product->photo);
            }
            $photo     = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('products', $photoName, 'public');
        }

        $product->update([
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'category'    => $validated['category'],
            'stock'       => $validated['stock'],
            'photo'       => $photoName,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete the specified product.
     */
    public function destroy(Product $product)
    {
        if ($product->photo) {
            Storage::disk('public')->delete('products/' . $product->photo);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}

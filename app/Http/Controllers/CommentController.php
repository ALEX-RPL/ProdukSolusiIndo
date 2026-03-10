<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment on a product.
     * Available to authenticated users and admins.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        Comment::create([
            'product_id' => $product->id,
            'user_id'    => Auth::id(),
            'content'    => $request->content,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Delete a comment (user can delete their own).
     */
    public function destroy(Comment $comment)
    {
        // Only the owner can delete their comment
        if ($comment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak berhak menghapus komentar ini.');
        }

        $productId = $comment->product_id;
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }

    /**
     * Delete any comment (admin only).
     */
    public function adminDestroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $productId = $request->query('product_id');
        $umkmId    = $request->query('umkm_id');

        $product = $productId ? Product::find($productId) : null;
        $umkm    = $umkmId    ? Umkm::find($umkmId)      : null;

        // If both are null, abort
        if (!$product && !$umkm) {
            abort(400, 'Target laporan tidak valid.');
        }

        $categories = Report::$categories;

        return view('reports.create', compact('product', 'umkm', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'  => 'nullable|exists:products,id',
            'umkm_id'     => 'nullable|exists:umkms,id',
            'category'    => 'required|in:' . implode(',', array_keys(Report::$categories)),
            'description' => 'required|string|min:20|max:1000',
        ], [
            'description.min' => 'Deskripsi laporan minimal 20 karakter.',
            'description.max' => 'Deskripsi laporan maksimal 1000 karakter.',
        ]);

        Report::create([
            'reporter_id' => Auth::id(),
            'product_id'  => $validated['product_id'] ?? null,
            'umkm_id'     => $validated['umkm_id'] ?? null,
            'category'    => $validated['category'],
            'description' => $validated['description'],
            'status'      => 'PENDING',
        ]);

        $redirectRoute = $validated['product_id']
            ? route('products.show', $validated['product_id'])
            : route('umkms.show', $validated['umkm_id']);

        return redirect($redirectRoute)->with('success', 'Laporan Anda telah berhasil dikirim. Tim kami akan meninjau laporan ini segera. Terima kasih!');
    }
}

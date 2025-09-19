<?php
namespace App\Http\Controllers;

use App\Models\BarangPeminjaman;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BarangPeminjamanController extends Controller
{
    public function index()
    {
        $items = BarangPeminjaman::orderBy('created_at', 'desc')->get();
        return Inertia::render('Barang/Index', [
            'items' => $items
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:Dipinjam,Dikembalikan',
        ]);
        $item = BarangPeminjaman::create($validated);
        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = BarangPeminjaman::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'jumlah' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:Dipinjam,Dikembalikan',
        ]);
        $item->update($validated);
        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = BarangPeminjaman::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    public function returnItem($id)
    {
        $item = BarangPeminjaman::findOrFail($id);
        $item->status = 'Dikembalikan';
        $item->save();
        return redirect()->back()->with('success', 'Item returned successfully.');
    }
}

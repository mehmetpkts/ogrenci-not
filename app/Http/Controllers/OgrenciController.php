<?php

namespace App\Http\Controllers;

use App\Models\Ogrenci;
use Illuminate\Http\Request;

class OgrenciController extends Controller
{
    public function index()
    {
        $q = request('q') ?? request('o');
        if (is_string($q)) {
            $q = trim($q, "\"' ");
        }

        $items = Ogrenci::query()
            ->when($q, function ($query, $q) {
                $query->where('ad_soyad', 'like', "%$q%");
            })
            ->get();

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ad_soyad' => ['required', 'string', 'max:255'],
        ]);

        $ogrenci = Ogrenci::create($data);
        return response()->json($ogrenci, 201);
    }

    public function show(Ogrenci $ogrenci)
    {
        return response()->json($ogrenci);
    }

    public function update(Request $request, Ogrenci $ogrenci)
    {
        $data = $request->validate([
            'ad_soyad' => ['required', 'string', 'max:255'],
        ]);

        $ogrenci->update($data);
        return response()->json($ogrenci);
    }

    public function destroy(Ogrenci $ogrenci)
    {
        $ogrenci->delete();
        return response()->json(['message' => 'Silindi']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Egitmen;
use Illuminate\Http\Request;

class EgitmenController extends Controller
{
    public function index()
    {
        $q = request('q') ?? request('e');
        if (is_string($q)) {
            $q = trim($q, "\"' ");
        }

        $items = Egitmen::query()
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

        $egitmen = Egitmen::create($data);
        return response()->json($egitmen, 201);
    }

    public function show(Egitmen $egitmen)
    {
        return response()->json($egitmen);
    }

    public function update(Request $request, Egitmen $egitmen)
    {
        $data = $request->validate([
            'ad_soyad' => ['required', 'string', 'max:255'],
        ]);

        $egitmen->update($data);
        return response()->json($egitmen);
    }

    public function destroy(Egitmen $egitmen)
    {
        $egitmen->delete();
        return response()->json(['message' => 'Silindi']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Egitmen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'egitmen_no' => ['required', 'string', 'max:50', 'unique:egitmenler,egitmen_no'],
            'telefon_numarasi' => ['required', 'string', 'max:11'],
            'okul_email' => ['required', 'string', 'email', 'max:255', 'unique:egitmenler,okul_email'],
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
            'egitmen_no' => ['required', 'string', 'max:50', Rule::unique('egitmenler', 'egitmen_no')->ignore($egitmen->id)],
            'telefon_numarasi' => ['required', 'string', 'max:11'],
            'okul_email' => ['required', 'string', 'email', 'max:255', Rule::unique('egitmenler', 'okul_email')->ignore($egitmen->id)],
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

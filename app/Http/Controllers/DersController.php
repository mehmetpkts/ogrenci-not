<?php

namespace App\Http\Controllers;

use App\Models\Ders;
use Illuminate\Http\Request;

class DersController extends Controller
{
    public function index()
    {
        return response()->json(Ders::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ad' => ['required', 'string', 'max:255'],
            'egitmen_id' => ['required', 'integer', 'exists:egitmenler,id'],
        ]);

        $ders = Ders::create($data);
        return response()->json($ders, 201);
    }

    public function show(Ders $ders)
    {
        return response()->json($ders);
    }

    public function update(Request $request, Ders $ders)
    {
        $data = $request->validate([
            'ad' => ['required', 'string', 'max:255'],
            'egitmen_id' => ['required', 'integer', 'exists:egitmenler,id'],
        ]);

        $ders->update($data);
        return response()->json($ders);
    }

    public function destroy(Ders $ders)
    {
        $ders->delete();
        return response()->json(['message' => 'Silindi']);
    }
}

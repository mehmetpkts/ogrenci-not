<?php

namespace App\Http\Controllers;

use App\Models\Not as NotModel;
use Illuminate\Http\Request;

class NotController extends Controller
{
    public function index()
    {
        $q = request('q') ?? request('n');
        if (is_string($q)) {
            $q = trim($q, "\"' ");
        }

        $items = NotModel::query()
            ->when($q !== null && $q !== '', function ($query) use ($q) {
                if (is_numeric($q)) {
                    $query->where('not', (int)$q);
                } else {
                    $query->where('not', 'like', "%$q%");
                }
            })
            ->get();

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ogrenci_id' => ['required', 'integer', 'exists:ogrenciler,id'],
            'ders_id' => ['required', 'integer', 'exists:dersler,id'],
            'not' => ['required', 'integer'],
        ]);

        $not = NotModel::create($data);
        return response()->json($not, 201);
    }

    public function show(NotModel $not)
    {
        return response()->json($not);
    }

    public function update(Request $request, NotModel $not)
    {
        $data = $request->validate([
            'ogrenci_id' => ['required', 'integer', 'exists:ogrenciler,id'],
            'ders_id' => ['required', 'integer', 'exists:dersler,id'],
            'not' => ['required', 'integer'],
        ]);

        $not->update($data);
        return response()->json($not);
    }

    public function destroy(NotModel $not)
    {
        $not->delete();
        return response()->json(['message' => 'Silindi']);
    }
}

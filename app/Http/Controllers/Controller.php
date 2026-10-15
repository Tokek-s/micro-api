<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // GET /items
    public function index()
    {
        $items = Item::all();
        return response()->json($items, 200);
    }

    // POST /items
    public function store(Request $request)
    {
        // Validación de los datos requeridos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $item = Item::create($validatedData);

        return response()->json($item, 201);
    }
}
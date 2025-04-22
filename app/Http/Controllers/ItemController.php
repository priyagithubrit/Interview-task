<?php

namespace App\Http\Controllers;
use App\Models\Item;

use Illuminate\Http\Request;

class ItemController extends Controller
{

public function create()
{
    $items = Item::latest()->get(); 
    return view('items.create', compact('items'));
}

public function store(Request $request)
{
    $request->validate([
        'items.*.name' => 'required|string',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    foreach ($request->items as $item) {
        Item::create([
            'name' => $item['name'],
            'quantity' => $item['quantity'],
        ]);
    }

    return redirect()->route('items.create')->with('success', 'Items saved successfully.');
}

}

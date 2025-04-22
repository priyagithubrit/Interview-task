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

public function edit(Item $item)
{
    $items = Item::latest()->get();
    return view('items.create', compact('item', 'items'));
}

public function update(Request $request, Item $item)
{
    $request->validate([
        'name' => 'required|string',
        'quantity' => 'required|integer|min:1',
    ]);

    $item->update($request->only('name', 'quantity'));
    return redirect()->route('items.create')->with('success', 'Item updated successfully.');
}

public function destroy(Item $item)
{
    $item->delete();
    return redirect()->route('items.create')->with('success', 'Item deleted successfully.');
}

}

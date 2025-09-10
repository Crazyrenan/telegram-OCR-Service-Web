<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->get(); // Get all items, newest first
        return view('items.index', compact('items'));
    }


    public function create()
    {
        return view('items.create');
    }

 
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create the new item
        Item::create($request->all());

        // Redirect back to the main list with a success message
        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update the item
        $item->update($request->all());

        // Redirect back to the main list with a success message
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }


      public function apiIndex()
    {
        return Item::all();
    }


    public function sendToTelegram()
    {
        $items = Item::all();
        
        if ($items->isEmpty()) {
            return back()->with('success', 'There is no data to send.');
        }

        // Format the data into an HTML string for Telegram
        $message = "<b>Item Report from Website:</b>\n\n";
        $message .= "<pre>| ID | Name              | Description         |\n";
        $message .= "|----|-------------------|---------------------|\n";
        foreach ($items as $item) {
            $itemId = str_pad($item->id, 2);
            $name = str_pad(substr($item->name, 0, 15), 17);
            $description = str_pad(substr($item->description, 0, 19), 19);
            $message .= "| {$itemId} | {$name} | {$description} |\n";
        }
        $message .= "</pre>";

        Http::post('http://127.0.0.1:5001/send-message', [
            'message' => $message,
        ]);

        return redirect()->route('items.index')->with('success', 'Item list sent to Telegram!');
    }
}


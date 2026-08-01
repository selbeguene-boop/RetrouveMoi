<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // Afficher tous les objets
    public function index()
    {
        return response()->json(Item::with(['category', 'user'])->get());
    }


    // Ajouter un objet
  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'status' => 'required|in:perdu,trouve',
        'location' => 'required|string',
        'date' => 'required|date',
        'category_id' => 'required|exists:categories,id',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('items', 'public');
    }

    $item = Item::create([
        'title' => $request->title,
        'description' => $request->description,
        'image' => $imagePath,
        'status' => $request->status,
        'location' => $request->location,
        'date' => $request->date,
        'category_id' => $request->category_id,
        'user_id' => auth()->id(),
    ]);

    return response()->json([
        'message' => 'Objet ajouté avec succès',
        'item' => $item
    ], 201);
}


    // Afficher un objet
    public function show(Item $item)
    {
        return response()->json($item);
    }


    // Modifier un objet
public function update(Request $request, Item $item)
{
    $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
    'status' => 'required|in:perdu,trouve',
    'location' => 'required|string',
]);
$imagePath = $item->image;

if ($request->hasFile('image')) {

    if ($item->image && Storage::disk('public')->exists($item->image)) {
        Storage::disk('public')->delete($item->image);
    }

    $imagePath = $request->file('image')->store('items', 'public');
}
       $item->update([
    'title' => $request->title,
    'description' => $request->description,
    'image' => $imagePath,
    'status' => $request->status,
    'location' => $request->location,
]);
    return response()->json([
        'message' => 'Objet modifié avec succès',
        'item' => $item->fresh()
    ]);
}

    // Supprimer un objet
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            'message' => 'Objet supprimé avec succès'
        ]);
    }
}
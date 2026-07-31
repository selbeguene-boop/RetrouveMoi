<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

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
            'image' => 'nullable|string',
            'status' => 'required|in:perdu,trouve',
            'location' => 'required|string',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        $item = Item::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
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
        'status' => 'required|in:perdu,trouve',
        'location' => 'required|string',
    ]);

    $item->update([
        'title' => $request->title,
        'description' => $request->description,
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
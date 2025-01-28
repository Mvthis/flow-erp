<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Lister tous les produits
    public function index(Request $request)
    {
        // Récupérer les paramètres de la requête
        $search = $request->query('search'); // Rechercher par nom ou catégorie
        $category = $request->query('category'); // Filtrer par catégorie
        $minPrice = $request->query('min_price'); // Filtrer par prix minimum
        $maxPrice = $request->query('max_price'); // Filtrer par prix maximum
        $sortBy = $request->query('sort_by', 'name'); // Tri par défaut : nom
        $order = $request->query('order', 'asc'); // Ordre par défaut : ascendant
        $low_stock = $request->query('low_stock'); // Afficher les produits en faible stock

        // Construire la requête de base
        $query = Product::query();

        // Recherche par nom ou catégorie
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('category', 'like', "%$search%");
            });
        }

        // Filtrage par catégorie
        if ($category) {
            $query->where('category', $category);
        }

        // Filtrage par prix
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Filtrage par faible stock
        if ($low_stock) {
            $query->where('quantity', '<', 5);
        }

        // Appliquer le tri
        $query->orderBy($sortBy, $order);

        // Exécuter la requête et récupérer les résultats
        $products = $query->paginate(12); // 10 produits par page

        return response()->json($products, 200);
    }


    // Créer un nouveau produit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product,
        ], 201);
    }

    // Afficher les détails d'un produit
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    // Mettre à jour un produit
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:255',
        ]);

        $product->update(array_filter($validated));

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ], 200);
    }

    // Supprimer un produit
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}

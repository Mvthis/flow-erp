<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;


class InvoiceController extends Controller
{
    // Lister toutes les factures
    public function index()
    {
        $invoices = Invoice::with('products')->paginate(10);
        return response()->json($invoices, 200);
    }

    // Créer une nouvelle facture
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $invoice = Invoice::create([
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'] ?? null,
            'include_vat' => $request->input('include_vat', true),
        ]);

        $total = 0;

        foreach ($validated['products'] as $item) {
            $product = Product::find($item['id']);

            // Vérifie si le stock est suffisant
            if ($product->quantity < $item['quantity']) {
                return response()->json([
                    'error' => "Insufficient stock for product: {$product->name}",
                ], 400);
            }

            $product->quantity -= $item['quantity'];
            $product->save();

            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            $invoice->products()->attach($product, [
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        if ($invoice->include_vat) {
            $total *= 1.2; // Ajout de 20% de TVA
        }

        $invoice->update(['total' => $total]);

        return response()->json([
            'message' => 'Invoice created successfully',
            'invoice' => $invoice->load('products'),
        ], 201);
    }


    // Afficher une facture
    public function show($id)
    {
        $invoice = Invoice::with('products')->find($id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        return response()->json($invoice, 200);
    }

    // Supprimer une facture
    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully'], 200);
    }

    public function downloadPDF($id)
    {
        $invoice = Invoice::with('products')->find($id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $invoice]);


        return $pdf->download('invoice-' . $invoice->id . '.pdf');
    }

}

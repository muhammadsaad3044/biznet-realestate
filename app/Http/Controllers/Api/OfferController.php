<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;


class OfferController extends Controller
{
    // List all offers
public function index()
{
    try {
        $offers = Offer::with('product')->get();
        return response()->json($offers);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to fetch offers.', 'error' => $e->getMessage()], 500);
    }
}

    // Store new offer
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'offer_price' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
            ]);

            $offer = Offer::create([
                'product_id' => $request->product_id,
                'offer_price' => $request->offer_price,
                'user_id' => $request->user_id,
            ]);

            return response()->json(['message' => 'Offer submitted successfully!', 'offer' => $offer]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to submit offer.', 'error' => $e->getMessage()], 500);
        }
    }

    // Show one offer
    public function show($id)
    {
        try {
            $offer = Offer::with('product')->findOrFail($id);
            return response()->json($offer);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Offer not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch offer.', 'error' => $e->getMessage()], 500);
        }
    }

    // Update offer
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'offer_price' => 'required|numeric',
            ]);

            $offer = Offer::findOrFail($id);
            $offer->update([
                'offer_price' => $request->offer_price,
            ]);

            return response()->json(['message' => 'Offer updated successfully!', 'offer' => $offer]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Offer not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update offer.', 'error' => $e->getMessage()], 500);
        }
    }

    // Delete offer
    public function destroy($id)
    {
        try {
            $offer = Offer::findOrFail($id);
            $offer->delete();

            return response()->json(['message' => 'Offer deleted successfully!']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Offer not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete offer.', 'error' => $e->getMessage()], 500);
        }
    }
}

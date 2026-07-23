<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreInventarisRequest;
use App\Models\InventarisUks;
use Illuminate\Http\JsonResponse;

/**
 * Class InventarisUksController
 *
 * API Controller managing UKS inventory (Inventaris UKS) items with tenant isolation.
 *
 * @package App\Http\Controllers\Api\V1
 */
class InventarisUksController extends Controller
{
    /**
     * Display a listing of the tenant's UKS inventory.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $inventory = InventarisUks::all();

        return response()->json([
            'message' => 'UKS inventory retrieved successfully.',
            'data' => $inventory,
        ], 200);
    }

    /**
     * Store a newly created UKS inventory item.
     *
     * @param StoreInventarisRequest $request
     * @return JsonResponse
     */
    public function store(StoreInventarisRequest $request): JsonResponse
    {
        /** @var InventarisUks $item */
        $item = InventarisUks::create($request->validated());

        return response()->json([
            'message' => 'UKS inventory item created successfully.',
            'data' => $item,
        ], 201);
    }

    /**
     * Update the specified UKS inventory item.
     *
     * @param StoreInventarisRequest $request
     * @param InventarisUks $inventarisUks
     * @return JsonResponse
     */
    public function update(StoreInventarisRequest $request, InventarisUks $inventarisUks): JsonResponse
    {
        $inventarisUks->update($request->validated());

        return response()->json([
            'message' => 'UKS inventory item updated successfully.',
            'data' => $inventarisUks,
        ], 200);
    }

    /**
     * Remove the specified UKS inventory item from storage.
     *
     * @param InventarisUks $inventarisUks
     * @return JsonResponse
     */
    public function destroy(InventarisUks $inventarisUks): JsonResponse
    {
        $inventarisUks->delete();

        return response()->json([
            'message' => 'UKS inventory item deleted successfully.',
        ], 200);
    }
}

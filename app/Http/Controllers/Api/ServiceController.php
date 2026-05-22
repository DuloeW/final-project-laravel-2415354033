<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $status = $request->query("status");

        $query = Service::query();

        if ($status !== null) {
            if (!in_array($status, ["active","inactive"], true)) {
                return response()->json([
                    "success" => false,
                    "message" => "Validation failed",
                    "errorr" => [
                        "status" => "Invalid status value. Allowed values are 'active' or 'inactive'."
                    ],
                ], 422);
            }

            $query->where("status", $status === "active");
        }

        $services = $query->latest()->get();
        
        return response()->json([
            "success" => true,
            "message" => "Service retrieved successfully",
            "data" => $services,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "price" => "required|integer|min:0",
            "description" => "nullable|string",
            "status" => "required|boolean",
        ]);

        $data["status"] = $data["status"] ?? true;

        $service = Service::create($data);

        return response()->json([
            "success" => true,
            "message" => "Service created successfully",
            "data" => $service,
        ], 201);
    }
    
    public function show(int $id): JsonResponse
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Service retrieved successfully",
            "data" => $service,
        ]);
    }

    public function update (Request $request, int $id): JsonResponse
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
                "errors" => []
            ], 404);
        }

        $data = $request->validate([
            "name" => "sometimes|required|string|max:255",
            "price" => "sometimes|required|integer|min:0",
            "description" => "nullable|string",
            "status" => "sometimes|required|boolean",
        ]);

        $service->update($data);

        return response()->json([
            "success" => true,
            "message" => "Service updated successfully",
            "data" => $service,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
            ], 404);
        }

        $service->delete();

        return response()->json([
            "success" => true,
            "message" => "Service deleted successfully",
        ]);
    }

    public function activate(int $id): JsonResponse
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
            ], 404);
        }

        $service->update(["status" => true]);

        return response()->json([
            "success" => true,
            "message" => "Service activated successfully",
            "data" => $service,
        ]);
    }

    public function deactivate(int $id): JsonResponse
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                "success" => false,
                "message" => "Service not found",
            ], 404);
        }

        $service->update(["status" => false]);

        return response()->json([
            "success" => true,
            "message" => "Service deactivated successfully",
            "data" => $service,
        ]);
    }
}

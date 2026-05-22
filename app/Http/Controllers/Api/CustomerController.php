<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(): JsonResponse
    {
        $customers = Customer::latest()->get();

        return response()->json([
            "success" => true,
            "message" => "Customers retrieved successfully",
            "data" => $customers,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "Customer not found",
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Customer retrieved successfully",
            "data" => $customer,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "customer_id" => "required|string|max:255|unique:customers,customer_id",
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:customers,email",
            "phone" => "nullable|string|max:255",
            "address" => "nullable|string",
            "status" => "sometimes|boolean",
        ]);

        $data["status"] = $data["status"] ?? true;

        $customer = Customer::create($data);

        return response()->json([
            "success" => true,
            "message" => "Customer created successfully",
            "data" => $customer,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "Customer not found",
            ], 404);
        }

        $data = $request->validate([
            "customer_id" => "sometimes|required|string|max:255|unique:customers,customer_id,{$customer->id}",
            "name" => "sometimes|required|string|max:255",
            "email" => "sometimes|required|email|max:255|unique:customers,email,{$customer->id}",
            "phone" => "nullable|string|max:255",
            "address" => "nullable|string",
            "status" => "sometimes|boolean",
        ]);

        $customer->update($data);

        return response()->json([
            "success" => true,
            "message" => "Customer updated successfully",
            "data" => $customer,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "Customer not found",
            ], 404);
        }

        $customer->delete();

        return response()->json([
            "success" => true,
            "message" => "Customer deleted successfully",
        ]);
    }
}

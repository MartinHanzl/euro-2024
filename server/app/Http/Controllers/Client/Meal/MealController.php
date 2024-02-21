<?php

namespace App\Http\Controllers\Client\Meal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\Meal\MealResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Meal\Meal;

class MealController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $meals = Meal::query()->get();
        return Response::json([
            'success' => true,
            'data' => MealResource::collection($meals)
        ]);
    }

    public function save(Request $request, int $id = null): JsonResponse
    {
        return Response::json();
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $query = User::query();

        if ($request->has('active')) {
            $query->where('active', '=', 1);
        }
        $users = $query->get();
        return Response::json(UserResource::collection($users));
    }
}

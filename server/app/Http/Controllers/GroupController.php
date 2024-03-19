<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;


class GroupController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $groups = Group::with('games')->get();
        return Response::json(GroupResource::collection($groups));
    }

    public function detail(Request $request, int $id): JsonResponse
    {
        if (!$id) {
            App::abort(400);
        }

        $group = Group::with('games')->find($id);

        if (!$id) {
            App::abort(404);
        }

        return Response::json(GroupResource::make($group));
    }

    public function save(Request $request, int $id = null): JsonResponse
    {
        if ($id) {
            $group = Group::query()->find($id);
            if (!$group) {
                $group = new Group();
            }
        } else {
            $group = new Group();
        }

        $group->fill($request->all());
        $group->save();

        return Response::json(GroupResource::make($group));
    }

    public function delete(Request $request, int $id): JsonResponse
    {
        if (!$id) {
            App::abort(400);
        }

        $group = Group::query()->find($id);

        if (!$group) {
            App::abort(404);
        }

        $group->delete();

        return Response::json();
    }
}

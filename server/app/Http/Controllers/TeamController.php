<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\Blog\PostResource;
use App\Http\Resources\TeamResource;
use App\Models\Blog\Post;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class TeamController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        return Response::json(
            TeamResource::collection(Team::query()->get())
        );
    }

    public function detail(Request $request, int $id): JsonResponse
    {
        if (!$id) {
            App::abort(400);
        }

        $team = Team::query()->find($id);

        if (!$team) {
            App::abort(404);
        }

        return Response::json(TeamResource::make($team));
    }

    public function save(Request $request, int $id = null): JsonResponse
    {
        if ($id) {
            $team = Team::query()->find($id);
        } else {
            $team = new Team();
        }

        $team->fill($request->all());

        $team->save();

        return Response::json(TeamResource::make($team));
    }

    public function delete(Request $request, int $id): JsonResponse
    {
        if (!$id) {
            App::abort(400);
        }

        $team = Team::query()->find($id);

        if (!$id) {
            App::abort(404);
        }

        $team->delete();

        return Response::json();
    }
}

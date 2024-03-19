<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;


class TeamController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $teams = Team::with(['homeGames', 'awayGames'])->get();
        return Response::json(TeamResource::collection($teams)
        );
    }

    public function detail(Request $request, int $id): JsonResponse
    {
        if (!$id) {
            App::abort(400);
        }

        $team = Team::with(['homeGames', 'awayGames'])->find($id);

        if (!$team) {
            App::abort(404);
        }

        return Response::json(TeamResource::make($team));
    }

    public function save(Request $request, int $id = null): JsonResponse
    {
        if ($id) {
            $team = Team::query()->find($id);
            if (!$team) {
                $team = new Team();
            }
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

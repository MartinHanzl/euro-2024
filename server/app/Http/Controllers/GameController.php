<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;


class GameController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $query = Game::with([
            'homeTeam',
            'awayTeam',
        ]);

        if ($request->has('type')) {
            $query->where('type', '=', $request->get('type'));
        } else {
            $query->where('type', '!=', 'group');
        }

        $games = $query->get();

        foreach ($games as $game) {
            $game->tip = Tip::query()
                ->where('user_id', '=', $request->user()->id)
                ->first();
        }

        return Response::json(GameResource::collection($games));
    }

    public function detail(Request $request, int $id): JsonResponse
    {
        if (!$id) {
            App::abort(400);
        }

        $game = Game::with([
            'homeTeam',
            'awayTeam',
        ])->find($id);

        if (!$game) {
            App::abort(404);
        }

        $game->tips = Tip::query()
            ->where('user_id', '=', 1)
            ->get();

        return Response::json(GameResource::make($game));
    }

    public function save(Request $request, int $id = null): JsonResponse
    {
        if ($id) {
            $game = Game::query()->find($id);
            if (!$game) {
                App::abort(404);
            }
        } else {
            $game = new Game();
        }

        $game->fill($request->all());

        $game->save();

        return Response::json(GameResource::make($game));
    }

    public function delete(Request $request, int $id): JsonResponse
    {
        if (!$id) {
            App::abort(400);
        }

        $game = Game::query()->find($id);

        if (!$game) {
            App::abort(404);
        }

        return Response::json();
    }
}

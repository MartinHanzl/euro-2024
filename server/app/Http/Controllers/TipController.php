<?php

namespace App\Http\Controllers;

use App\Http\Resources\TipResource;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TipController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $tips = Tip::query()
            ->where('user_id', '=', $request->user()->id)
            ->get();

        return Response::json(TipResource::collection($tips));
    }

    public function detail(Request $request, int $id): JsonResponse
    {
        if (!$id) {
            App::abort(400);
        }

        $tip = Tip::query()
            ->where('id', '=', $id)
            ->where('user_id', '=', $request->user()->id)
            ->first();

        if (!$tip) {
            App::abort(404);
        }

        return Response::json(TipResource::make($tip));
    }

    public function save(Request $request, int $id = null): JsonResponse
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'game_id' => 'required|int',
            'home_goals' => 'required|int',
            'away_goals' => 'required|int'
        ]);

        if ($validator->fails()) {
            App::abort(400);
        }

        if ($id) {
            $tip = Tip::query()
                ->where('user_id', '=', $request->user()->id)
                ->find($id);
        } else {
            $tip = new Tip();
        }

        $tip->fill($data);

        $tip->save();

        return Response::json(TipResource::make($tip));
    }

    public function delete(Request $request, int $id): JsonResponse
    {
        if (!$id) {
            App::abort(400);
        }

        $tip = Tip::query()
            ->where('user_id', '=', $request->user()->id)
            ->find($id);

        if (!$tip) {
            App::abort(404);
        }

        $tip->delete();

        return Response::json();
    }
}

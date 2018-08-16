<?php

namespace Videostat\Http\Controllers\Api;

use Illuminate\Http\Request;

use Videostat\Contracts\Database\Repositories\GameStreamStatRepository;
use Videostat\Http\Controllers\Controller;
use Videostat\Http\Resources\GameStreamCollection;

use Videostat\Contracts\Database\Repositories\GameRepository;
use Videostat\Contracts\Database\Repositories\GameServiceRepository;

class StreamController extends Controller
{
    public function index(
        Request $request,
        GameRepository $game_repository,
        GameServiceRepository $game_service_repository,
        GameStreamStatRepository $game_stream_stat_repository
    ) {
        $games_services = $game_service_repository->findActiveForGames($game_repository->findAll(explode(',', $request->games_ids)));

        $streams_list = $game_stream_stat_repository->findStreamsListForGamesServices(
            $games_services,
            $request->period_start,
            $request->period_end,
            $request->limit,
            $request->offset
        );

        return new GameStreamCollection($streams_list);
    }

    public function viewers(
        Request $request,
        GameRepository $game_repository,
        GameServiceRepository $game_service_repository,
        GameStreamStatRepository $game_stream_stat_repository
    ) {
        $games_services = $game_service_repository->findActiveForGames($game_repository->findAll(explode(',', $request->games_ids)));
        $streams_list = $game_stream_stat_repository->findStreamsViewersForGamesServices(
            $games_services,
            $request->period_start,
            $request->period_end,
            $request->limit,
            $request->offset
        );

        return new GameStreamCollection($streams_list);
    }
}

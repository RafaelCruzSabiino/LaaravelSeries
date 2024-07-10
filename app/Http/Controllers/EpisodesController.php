<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    public function index(Season $season)
    {
        return view('episodes.index')->with('episodes', $season->episodes);
    }

    public function update(Request $request, Season $season)
    {
        $watchedEp = $request->episodes;
        $season->episodes->each(function (Episode $episode) use ($watchedEp){
            $episode->watched = in_array($episode->id, $watchedEp);
            //$episode->save();
        });

        $season->push();

        return to_route('seasons.index', $season->series_id)->with('mensagem.sucesso', 'Episodios Marcados com Sucesso!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Season;
use App\Models\Episode;
use App\Http\Requests\SeriesFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        //$series = Serie::with(['seasons'])->get();
        $series = Serie::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')->with('series', $series)->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        // DB::beginTransaction();

        // try
        // {
        //     CODE...
        //     DB::commit();
        // }
        // catch(Exception $e)
        // {
        //     DB::rollBack();
        // }

        $serie = DB::transaction(function () use ($request)
        {
            $serie    = Serie::create($request->all());
            $seasons  = [];
            $episodes = [];
    
            for($i = 1; $i <= $request->seasonsQty; $i++)
            {
                $seasons[] = [
                    'series_id' => $serie->id,
                    'number' => $i
                ];
            }
    
            Season::insert($seasons);
    
            foreach($serie->seasons as $season)
            {
                for($j = 1; $j <= $request->epsiodeQty; $j++)
                {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j
                    ];
                }
            }
            
            Episode::insert($episodes);

            return $serie;
        });

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
    }

    public function destroy(Serie $series)
    {
        $series->delete();

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");
    }

    public function eidt(Serie $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Serie $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
    }
}

<?php

namespace App\Repositories;

use App\Models\Serie;
use App\Models\Season;
use App\Models\Episode;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SeriesFormRequest;

class SeriesRepository
{
    public function add(SeriesFormRequest $request)
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

        return DB::transaction(function () use ($request)
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
    }
}

?>
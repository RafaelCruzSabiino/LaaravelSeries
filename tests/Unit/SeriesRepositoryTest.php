<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Repositories\ISeriesRepository;
use App\Http\Requests\SeriesFormRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_when_a_series_is_created_its_seasons_and_episodes_must_also_be_create()
    {
        $repository = $this->app->make(ISeriesRepository::class);
        $request    = new SeriesFormRequest();
        $request->nome = 'Nome da Serie';
        $request->seasonsQty = 1;
        $request->epsiodeQty = 1;
        
        $repository->add($request);

        $this->assertDatabaseHas('series', ['nome' => 'Nome da Serie']);
        $this->assertDatabaseHas('seasons', ['number' => '1']);
        $this->assertDatabaseHas('episodes', ['number' => '1']);
    }
}

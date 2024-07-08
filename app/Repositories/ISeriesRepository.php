<?php

namespace App\Repositories;

use App\Models\Serie;
use App\Http\Requests\SeriesFormRequest;

interface ISeriesRepository
{
    public function add(SeriesFormRequest $request) : Serie;
}
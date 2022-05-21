<?php

namespace App\Services;

use App\Exceptions\ParametersErrorException;
use App\Models\News;
use App\Models\Rubric;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RubricService
{
    public function find($id)
    {
        return Rubric::where('id', $id)
            ->first();
    }

    public function create($attributes)
    {
        return Rubric::create($attributes);
    }

    public function index()
    {
        return $rubrics = Rubric::with(['childrenWith', 'news' ])
            ->whereNull('parent_id')
            ->get();
    }
}
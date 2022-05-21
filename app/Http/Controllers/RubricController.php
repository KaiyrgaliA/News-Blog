<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRubricRequest;
use App\Http\Resources\GetRubricResource;
use App\Services\RubricService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RubricController extends Controller
{
    public function __construct(
        protected RubricService $rubricService
    )
    {
    }
    public function create(CreateRubricRequest $request)
    {
        $validatedRequest = $request->validated();
        $this->rubricService->create($validatedRequest);
        return response()->json(
            [
                'message' => 'Рубрика успешно создано'
            ], Response::HTTP_CREATED
        );
    }

    public function index()
    {
        return GetRubricResource::collection($this->rubricService->index());
    }
}

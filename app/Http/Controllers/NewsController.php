<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\GetNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notification;

class NewsController extends Controller
{
    public function __construct(
        protected NewsService $newsService
    )
    {     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetNewsRequest $request)
    {
        $validatedRequest = $request->validated();
        return $this->newsService->index($validatedRequest);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNewsRequest $request)
    {
        $validatedRequest = $request->validated();
        $this->newsService->store($validatedRequest);
        return response()->json(
            [
                'message' => 'новость успешно создано'
            ], Response::HTTP_CREATED
        );   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(
            [
                'data' => $this->newsService->find($id)
            ], Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsRequest $request, $id)
    {
        $validatedRequest = $request->validated();
        $this->newsService->update($validatedRequest, $id);
        return response()->json(
            [
                'message' => 'успешно обновлено'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->newsService->destroy($id);
        return response()->json(
            [
                'message' => 'успешно удаленно'
            ], Response::HTTP_OK
        );
    }
}

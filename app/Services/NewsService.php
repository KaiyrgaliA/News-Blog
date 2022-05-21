<?php

namespace App\Services;

use App\Exceptions\ParametersErrorException;
use App\Models\News;
use App\Models\NewsRubric;
use App\Models\User;
// use Illuminate\Support\Facades\Notification;
use Notification;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class NewsService
{
    public function __construct(
        protected RubricService $rubricService
    )
    {        
    }

    public function store($attributes)
    {
        $authUser = Auth::user();
        $attributes['author_id'] = $authUser->id;
        $rubric = $this->rubricService->find($attributes['rubric_id']);
        $news = News::create([
            'title' => $attributes['title'],
            'anounce' => $attributes['anounce'],
            'text' => $attributes['text'],
            'author_id' => $attributes['author_id']
        ]);
        NewsRubric::create(
            [
                'news_id' => $news->id,
                'rubric_id' => $rubric->id
            ]
        );
        $project = [
            'body' => 'Новость - '.$attributes['title'].' успешно создано.',
            'thanks' => 'Спасибо за использование',
            'id' => 15
        ];
        // dd($authUser);
        Notification::send($authUser, new EmailNotification($project));
        return 'success';
    }

    public function index($attributes)
    {
        $title = data_get($attributes, 'title');
        $anounce = data_get($attributes, 'anounce');
        $authorName = data_get($attributes, 'author_name');
        $rubricTitle = data_get($attributes, 'rubric_title');

        return News
            ::when($title, function($query) use($title) {
                    $query->where('title', 'like', '%'.$title.'%');
            })
            ->when($anounce, function($query) use($anounce) {
                $query->where('title', 'like', '%'.$anounce.'%');
            })
            ->when($authorName, function($query) use($authorName) {
                $query->whereHas('authors', function ($q) use($authorName) {
                    return $q->where('name', 'like', '%'.$authorName.'%');
                });
            })
            ->when($rubricTitle, function($query) use($rubricTitle)
            {
                $query->whereHas('rubrics', function($q) use($rubricTitle)
                        {
                            return $q->where('title', 'like', '%'.$rubricTitle.'%');
                        }
                    );
            })
            ->with('authors')
            ->get();

    }

    public function find($id)
    {
        return News::findOrFail($id);
    }

    public function update($attributes, $id)
    {
        $news = $this->find($id);
        if($news->author_id != Auth::user()->id)
        {
            throw new ParametersErrorException('У вас нету доступа');
        }
        if(isset($attributes['rubric_id']))
        {
            $rubricId = $attributes['rubric_id'];
            $newsRubric = NewsRubric
                ::where('news_id', $news->id)
                ->where('rubric_id', $rubricId)
                ->first();
            $newsRubric->update(
                [
                    'rubric_id' => $rubricId
                ]
            );
            unset($attributes['rubric_id']);
        }
        $news->update($attributes);
        return 'success';
    }

    public function destroy($id)
    {
        $news = $this->find($id);
        return $news->delete();
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StoryController extends Controller
{
    public function index(Request $request): Response
    {
        $stories = Story::query()
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString()
            ->through(fn(Story $story) => [
                'id'     => $story->getKey(),
                'title'  => $story->title,
                'author' => $story->user->name,
            ]);

        return Inertia::render('Stories/Index', [
            'stories' => $stories,
        ]);
    }

    public function show(Request $request, Story $story): Response
    {
        return Inertia::render('Stories/Show', [
            'story' => [
                'title'   => $story->title,
                'content' => nl2br(e($story->content)),
                'author'  => $story->user->name,
            ]
        ]);
    }
}

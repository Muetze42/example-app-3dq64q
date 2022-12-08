<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Story;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Gate;

class StoryController extends Controller
{
    protected int $commentMaxLength = 500;

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $stories = Story::query()
            ->orderByDesc('created_at')
            ->paginate(10)
            ->through(fn(Story $story) => [
                'id'       => $story->getKey(),
                'title'    => $story->title,
                'author'   => $story->user->name,
                'comments' => $story->comments->count()
            ]);

        return Inertia::render('Stories/Index', [
            'stories' => $stories,
        ]);
    }

    /**
     * @param Request $request
     * @param Story $story
     * @return Response
     */
    public function show(Request $request, Story $story): Response
    {
        $comments = $story->comments()
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'commentPage')
            ->through(fn(Comment $comment) => [
                'id'      => $comment->getKey(),
                'content' => nl2br(e($comment->content)),
                'author'  => optional($comment->user)->name,
                'avatar'  => optional($comment->user)->getFirstMediaUrl('avatar', 'thumb'),
                'title'   => $comment->user ?
                    __(':user wrote at :date', ['user' => $comment->user->name, 'date' => $comment->created_at->format('m.d.Y H:i:s')]) :
                    __('A guest wrote at :date', ['date' => $comment->created_at->format('m.d.Y H:i:s')]),
            ]);

        return Inertia::render('Stories/Show', [
            'story' => [
                'id'      => $story->getKey(),
                'title'   => $story->title,
                'content' => nl2br(e($story->content)),
                'author'  => $story->user->name,
            ],
            'comments' => $comments,
            'commentMaxLength' => $this->commentMaxLength,
            'authorizedToAddComment' => Gate::allows('addComment', Story::class),
        ]);
    }

    /**
     * @param Story $story
     * @param Request $request
     * @throws AuthorizationException
     */
    public function addComment(Story $story, Request $request)
    {
        $this->authorize('addComment', Story::class);

        $request->validate([
            'content' => ['required', 'string', 'max:'.$this->commentMaxLength],
        ]);

        $story->comments()->create(['content' => $request->input('content')]);
    }
}

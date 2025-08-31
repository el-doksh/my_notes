<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = Topic::with('creator', 'parent')->latest()->get();

        return Inertia::render('topics/list', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topics = Topic::all();

        return Inertia::render('topics/edit', compact('topics'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicRequest $request)
    {
        $input = $request->validated();
        $input['created_by'] = Auth::user()->id;


        Topic::create($input);

        return redirect()->intended(route('topics.index', absolute: false));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        $topics = Topic::whereNot('id', $topic->id)->get();
        
        return Inertia::render('topics/edit', compact('topic', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $input = $request->validated();
        $input['updated_by'] = Auth::user()->id;

        $topic->update($input);

        return redirect()->intended(route('topics.index', absolute: false));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        try {
            $topic->delete();
            return redirect()->intended(route('topics.index', absolute: false));

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

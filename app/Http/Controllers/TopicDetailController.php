<?php

namespace App\Http\Controllers;

use App\Models\TopicDetail;
use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($topicUrl)
    {
        $topic = Topic::where('url', $topicUrl)->first();
        $topics = TopicDetail::where('topic_id', $topic->id)->latest()->get();

        return inertia('topic-details/list', compact('topics', 'topic'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($url)
    {
        $topic = Topic::whereNot('url', $url)->first();
        
        return Inertia::render('topics/edit', compact('topic'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($topicUrl)
    {
        $topic = Topic::where('url', $topicUrl)->first();
        $topics = TopicDetail::where('topic_id', $topic->id)->latest()->get();

        return inertia('topic-details/list', compact('topics', 'topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TopicDetail $topicDetail)
    {
        //
        $topics = Topic::whereNot('id', $topic->id)->get();
        
        return Inertia::render('topics/edit', compact('topic', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TopicDetail $topicDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TopicDetail $topicDetail)
    {
        //
    }
}

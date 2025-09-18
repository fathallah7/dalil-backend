<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkCreateRequest;
use App\Http\Requests\LinkUpdateRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $links = $request->user()->links()->with('tags')->get();
        return response()->json($links);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkCreateRequest $request)
    {
        $link = $request->user()->links()->create(
            $request->only([
                'title',
                'url'
            ])
        );

        $tags = $request->input('tags', []);
        $tagsIds = [];

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagsIds[] = $tag->id;
        }

        $link->tags()->sync($tagsIds);
        return response()->json($link, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        return response()->json($link->load('tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinkUpdateRequest $request, Link $link)
    {
        Gate::authorize('update', $link);

        $link->update($request->only(['title', 'url']));

        $tags = $request->input('tags', []);
        $tagsIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagsIds[] = $tag->id;
        }

        $link->tags()->sync($tagsIds);
        return response()->json($link);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        Gate::authorize('delete', $link);

        $link->delete();
        return response()->json(['message' => 'Link deleted successfully'], 204);
    }
}

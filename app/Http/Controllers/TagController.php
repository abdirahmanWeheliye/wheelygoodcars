<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount([
            'cars as sold_count' => function ($query) {
                $query->whereNotNull('sold_at');
            },
            'cars as unsold_count' => function ($query) {
                $query->whereNull('sold_at');
            },
        ])->get();
        
        $tags = $tags->sortByDesc(function ($tag) {
            return $tag->unsold_count + $tag->sold_count;
        });

        return view('admin.tags_overview', compact('tags'));
    }
}

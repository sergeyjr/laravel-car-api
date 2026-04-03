<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{

    public function show(string $name)
    {
        $page = Page::where('code', $name)
            ->where('is_active', true)
            ->firstOrFail();

        return view('page', [
            'title' => $page->title,
            'content' => $page->content,
        ]);
    }

}

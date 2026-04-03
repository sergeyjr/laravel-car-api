<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Page;
use Illuminate\Http\Request;

class SiteController extends Controller
{

    public function home()
    {
        return view('pages.home');
    }

    public function page(string $code)
    {
        $page = Page::where('code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.page', compact('page'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'body' => 'required',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Message saved!');
    }

}

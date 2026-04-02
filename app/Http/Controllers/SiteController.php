<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiteController extends Controller
{

    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        $path = base_path('README.md');
        $content = File::exists($path)
            ? File::get($path)
            : 'README.md not found';

        return view('pages.about', compact('content'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function dashboard()
    {
        return view('dashboard.index');
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

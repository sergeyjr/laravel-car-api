<?php

namespace App\Http\Controllers\Web;

use App\Infrastructure\Persistence\Models\ContactModel;
use App\Infrastructure\Persistence\Models\PageModel;
use Illuminate\Http\Request;

class SiteController extends Controller
{

    public function home()
    {
        return response()->json([
            'message' => 'Главная страница'
        ]);
    }

    public function page(string $code)
    {
        $page = PageModel::where('code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json($page);
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        ContactModel::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ваше сообщение успешно отправлено!'
        ]);
    }

}

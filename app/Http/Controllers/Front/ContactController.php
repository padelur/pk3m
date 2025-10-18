<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
	public function index(): View
	{
		$settings = Setting::first();
		return view('front.contact.index', compact('settings'));
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'email'],
			'message' => ['required', 'string'],
		]);

		ContactMessage::create($validated);

		return back()->with('success', 'Terima kasih, pesan Anda sudah terkirim.');
	}
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use App\Http\Controllers\Admin\Traits\ChecksPermissions;

class SettingController extends Controller
{
    use ChecksPermissions;

	public function index(): View
	{
        $this->checkPermission('settings.view');
		$setting = Setting::first();
		return view('admin.settings.index', compact('setting'));
	}

	public function edit(): View
	{
        $this->checkPermission('settings.edit');
		$setting = Setting::first();
		return view('admin.settings.edit', compact('setting'));
	}

	public function update(Request $request): RedirectResponse
	{
        $this->checkPermission('settings.edit');
		$validated = $request->validate([
			'company_name' => ['nullable','string','max:255'],
			'address' => ['nullable','string','max:500'],
			'email' => ['nullable','email'],
			'phone' => ['nullable','string','max:50'],
			'whatsapp_link' => ['nullable','url'],
			'instagram_url' => ['nullable','url'],
			'facebook_url' => ['nullable','url'],
			'linkedin_url' => ['nullable','url'],
			'catalog_pdf' => ['nullable','mimes:pdf','max:10240'],
			'map_embed_url' => ['nullable','url'],
		]);

		$setting = Setting::firstOrCreate([]);
		$data = $validated;
		if ($request->hasFile('catalog_pdf')) {
			if ($setting->catalog_pdf_path) {
				Storage::disk('public')->delete($setting->catalog_pdf_path);
			}
			$data['catalog_pdf_path'] = $request->file('catalog_pdf')->store('catalogs','public');
		}

		$setting->update($data);
		return redirect()->route('admin.settings.index')->with('success','Pengaturan diperbarui.');
	}
}

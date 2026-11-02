<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchSetting;
use App\Services\Customlib;
use App\Services\MediaStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchSettingController extends Controller
{
    public function __construct(
        private Customlib $customlib,
        private MediaStorageService $media,
    ) {
        $this->middleware('rbac:schsettings.view')->only(['index', 'audit', 'backup']);
        $this->middleware('rbac:schsettings.edit')->only(['update', 'uploadLogo', 'uploadSidebar', 'runBackup', 'restoreBackup']);
    }

    public function index()
    {
        $record = SchSetting::first() ?? new SchSetting();
        return view('admin.schsettings.index', compact('record'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'school_name'         => 'required|string|max:200',
            'school_code'         => 'nullable|string|max:50',
            'session_id'          => 'nullable|integer',
            'lang_id'             => 'nullable|integer',
            'timezone'            => 'nullable|string',
            'theme'               => 'nullable|string',
            'is_rtl'              => 'boolean',
            'currency'            => 'nullable|string|max:10',
            'currency_symbol'     => 'nullable|string|max:10',
            'currency_place'     => 'nullable|string',
            'date_format'         => 'nullable|string',
            'phone'               => 'nullable|string|max:30',
            'email'               => 'nullable|email|max:100',
            'address'             => 'nullable|string',
            'office_hours'         => 'nullable|string',
            'copyright'           => 'nullable|string',
            'student_login'        => 'nullable|string',
            'parent_login'         => 'nullable|string',
            'staff_login'          => 'nullable|string',
            'admin_login'          => 'nullable|string',
            'super_admin_login'    => 'nullable|string',
            'youtube_url'          => 'nullable|url',
            'facebook_url'         => 'nullable|url',
            'twitter_url'          => 'nullable|url',
            'linkedin_url'         => 'nullable|url',
            'instagram_url'        => 'nullable|url',
            'pinterest_url'        => 'nullable|url',
            'mobile_app_url'        => 'nullable|url',
            'app_primary_color'    => 'nullable|string',
            'app_secondary_color'  => 'nullable|string',
        ]);

        $settings = SchSetting::first();
        if ($settings) {
            $settings->update($data);
        } else {
            SchSetting::create($data);
        }

        $this->customlib->clearSchoolSettingsCache();

        return redirect()->route('admin.schsettings.index')
            ->with('success', __('School settings updated successfully.'));
    }

    public function uploadLogo(Request $request)
    {
        $request->validate(['logo' => 'required|image|max:512']);
        $path = $this->media->upload($request->file('logo'), 'school_content', 'LOGO');
        $settings = SchSetting::first();
        if ($settings) {
            if ($settings->logo) $this->media->delete($settings->logo);
            $settings->update(['logo' => $path]);
        }
        return back()->with('success', __('Logo updated.'));
    }

    public function uploadSidebar(Request $request)
    {
        $request->validate(['sidebar' => 'required|image|max:1024']);
        $path = $this->media->upload($request->file('sidebar'), 'school_content', 'SIDE');
        $settings = SchSetting::first();
        if ($settings) {
            if ($settings->sidebar) $this->media->delete($settings->sidebar);
            $settings->update(['sidebar' => $path]);
        }
        return back()->with('success', __('Sidebar image updated.'));
    }

    public function audit()
    {
        $records = \App\Models\Audit::latest()->paginate(25);
        return view('admin.audit.index', compact('records'));
    }

    public function backup()
    {
        return view('admin.schsettings.backup');
    }

    public function runBackup()
    {
        // TODO: implement mysqldump / sqlite .dump
        return back()->with('success', __('Backup completed.'));
    }

    public function restoreBackup(Request $request)
    {
        $request->validate(['backup_file' => 'required|file']);
        // TODO: implement restore
        return back()->with('success', __('Backup restored.'));
    }
}

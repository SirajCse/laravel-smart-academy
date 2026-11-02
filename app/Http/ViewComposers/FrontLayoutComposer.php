<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Services\Customlib;
use App\Models\FrontcmsMenu;

class FrontLayoutComposer
{
    public function __construct(private Customlib $customlib) {}

    public function compose(View $view): void
    {
        $settings = $this->customlib->getSchoolSettings();

        $menus = cache()->remember('front.menu', now()->addHour(), function () {
            return FrontcmsMenu::where('is_active', 1)
                ->whereNull('parent_id')
                ->with('children')
                ->orderBy('order')
                ->get();
        });

        $view->with([
            'schoolName'    => $settings->school_name ?? config('app.name'),
            'schoolLogo'    => $this->customlib->getSchoolLogo(),
            'theme'         => $settings->theme ?? 'default',
            'isRtl'         => (bool) ($settings->is_rtl ?? false),
            'menus'         => $menus,
            'facebookUrl'   => $settings->facebook_url ?? '',
            'twitterUrl'    => $settings->twitter_url ?? '',
            'linkedinUrl'   => $settings->linkedin_url ?? '',
            'instagramUrl'  => $settings->instagram_url ?? '',
            'youtubeUrl'    => $settings->youtube_url ?? '',
            'pinterestUrl'  => $settings->pinterest_url ?? '',
            'officeHours'   => $settings->office_hours ?? '',
            'phone'         => $settings->phone ?? '',
            'email'         => $settings->email ?? '',
            'address'       => $settings->address ?? '',
            'copyright'     => $settings->copyright ?? '',
        ]);
    }
}

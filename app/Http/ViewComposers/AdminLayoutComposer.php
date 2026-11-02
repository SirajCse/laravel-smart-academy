<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Services\Customlib;
use App\Services\RbacService;
use Illuminate\Support\Facades\Auth;
use App\Models\PermissionCategory;

/**
 * Injects shared layout variables into every admin view.
 *
 * Replaces the explicit triple-load pattern from CI3:
 *   $this->load->view('layout/header');
 *   $this->load->view('module/view');
 *   $this->load->view('layout/footer');
 *
 * In Laravel 12 we use Blade layout inheritance instead.
 */
class AdminLayoutComposer
{
    public function __construct(
        private Customlib $customlib,
        private RbacService $rbac,
    ) {}

    public function compose(View $view): void
    {
        $staff = Auth::guard('admin')->user();
        $settings = $this->customlib->getSchoolSettings();

        $view->with([
            'schoolName'   => $settings->school_name ?? config('app.name'),
            'schoolLogo'   => $this->customlib->getSchoolLogo(),
            'sidebarImage' => $this->customlib->getSidebarImage(),
            'currencySymbol' => $settings->currency_symbol ?? '$',
            'dateFormat'   => $settings->date_format ?? 'd-m-Y',
            'isRtl'        => (bool) ($settings->is_rtl ?? false),
            'theme'        => $settings->theme ?? 'default',
            'currentStaff'=> $staff,
            'staffName'    => $staff?->name,
            'staffImage'   => $staff?->image,
            'staffRole'    => $staff?->roles?->first()?->name,
            'isSuperAdmin' => $staff ? $this->rbac->isSuperAdmin($staff) : false,
            'menu'         => $this->buildMenu($staff),
            'activeSession' => $this->customlib->getActiveSession(),
            'languages'    => $this->customlib->getLanguageList(),
        ]);
    }

    private function buildMenu($staff): array
    {
        if (! $staff) return [];

        $categories = PermissionCategory::whereNull('parent_id')
            ->with('children')
            ->orderBy('id')
            ->get();

        $menu = [];
        foreach ($categories as $cat) {
            $permCode = $cat->short_code . '.view';
            if (! $this->rbac->isSuperAdmin($staff) && ! $staff->can($permCode)) {
                continue;
            }
            $menu[] = $cat;
        }

        return $menu;
    }
}

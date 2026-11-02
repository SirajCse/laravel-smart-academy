<?php

/**
 * Smart Academy — menu_helper.php
 *
 * Replaces CI3 application/helpers/menu_helper.php.
 * Renders the admin sidebar from the RBAC permission tree.
 */

use App\Models\PermissionCategory;

if (! function_exists('renderAdminSidebar')) {
    function renderAdminSidebar(): string
    {
        $rbac = app(\App\Services\RbacService::class);

        // All top-level permission categories (parent_id IS NULL).
        $categories = Cache()->remember('sidebar.menu', now()->addHour(), function () {
            return PermissionCategory::whereNull('parent_id')->orderBy('id')->get();
        });

        $html = '';
        foreach ($categories as $cat) {
            if (! $rbac->hasPermission($cat->short_code . '.view')) {
                continue;
            }

            $children = PermissionCategory::where('parent_id', $cat->id)->get();
            if ($children->isEmpty()) {
                $html .= view('partials.sidebar-item', ['item' => $cat])->render();
            } else {
                $html .= view('partials.sidebar-tree', ['item' => $cat, 'children' => $children])->render();
            }
        }

        return $html;
    }
}

if (! function_exists('getAdminMenu')) {
    function getAdminMenu(): array
    {
        return cache()->remember('admin.menu.array', now()->addHour(), function () {
            return \App\Models\PermissionCategory::whereNull('parent_id')
                ->with('children')
                ->orderBy('id')
                ->get()
                ->toArray();
        });
    }
}

if (! function_exists('renderFrontMenu')) {
    function renderFrontMenu(): string
    {
        $items = cache()->remember('front.menu', now()->addHour(), function () {
            return \App\Models\FrontcmsMenu::where('is_active', 1)->orderBy('order')->get();
        });

        $html = '<ul class="nav navbar-nav">';
        foreach ($items as $item) {
            $url = $item->page_id ? route('page.read', $item->slug) : $item->url;
            $target = $item->open_in_new_tab ? ' target="_blank"' : '';
            $html .= '<li><a href="' . $url . '"' . $target . '>' . e($item->title) . '</a></li>';
        }
        $html .= '</ul>';

        return $html;
    }
}

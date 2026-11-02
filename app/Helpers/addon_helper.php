<?php

/**
 * Smart Academy — addon_helper.php
 * Replaces CI3 application/helpers/addon_helper.php.
 */

use App\Models\Addon;

if (! function_exists('isAddonActive')) {
    function isAddonActive(string $name): bool
    {
        return app(\App\Services\ModuleLibService::class)->isModuleActive($name);
    }
}

if (! function_exists('getActiveAddons')) {
    function getActiveAddons(): array
    {
        return app(\App\Services\ModuleLibService::class)->getActiveModules();
    }
}

if (! function_exists('installAddon')) {
    function installAddon(string $name, string $version = '1.0.0'): bool
    {
        return app(\App\Services\ModuleLibService::class)->install($name, $version);
    }
}

if (! function_exists('uninstallAddon')) {
    function uninstallAddon(string $name): bool
    {
        return app(\App\Services\ModuleLibService::class)->uninstall($name);
    }
}

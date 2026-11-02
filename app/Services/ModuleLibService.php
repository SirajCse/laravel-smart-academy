<?php

namespace App\Services;

/**
 * Module library — replaces CI3's `Module_lib` library.
 *
 * Tracks which addons/modules are installed and active in the
 * `addons` table, and provides permission checks for them.
 */
class ModuleLibService
{
    public function isModuleActive(string $moduleName): bool
    {
        return cache()->remember("module.{$moduleName}.active", now()->addMinutes(5), function () use ($moduleName) {
            return \App\Models\Addon::where('name', $moduleName)
                ->where('is_active', 1)
                ->where('is_installed', 1)
                ->exists();
        });
    }

    public function getActiveModules(): array
    {
        return cache()->remember('modules.active', now()->addMinutes(5), function () {
            return \App\Models\Addon::where('is_active', 1)
                ->where('is_installed', 1)
                ->pluck('name')
                ->all();
        });
    }

    public function install(string $name, string $version = '1.0.0'): bool
    {
        return (bool) \App\Models\Addon::updateOrCreate(
            ['name' => $name],
            ['version' => $version, 'is_installed' => 1, 'is_active' => 1]
        );
    }

    public function uninstall(string $name): bool
    {
        cache()->forget("module.{$name}.active");
        return \App\Models\Addon::where('name', $name)->delete() > 0;
    }

    public function activate(string $name): bool
    {
        cache()->forget("module.{$name}.active");
        return \App\Models\Addon::where('name', $name)->update(['is_active' => 1]) > 0;
    }

    public function deactivate(string $name): bool
    {
        cache()->forget("module.{$name}.active");
        return \App\Models\Addon::where('name', $name)->update(['is_active' => 0]) > 0;
    }
}

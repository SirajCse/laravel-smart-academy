<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * One-command installer for Smart Academy.
 *
 * Replaces the CI3 web installer (was at /installer).
 * Usage: php artisan smart-academy:install
 */
class InstallSmartAcademy extends Command
{
    protected $signature = 'smart-academy:install {--seed : Run seeders}';
    protected $description = 'Run the Smart Academy installer (migrate + key + storage link + seed).';

    public function handle(): int
    {
        $this->info('=== Smart Academy Installer ===');

        if (! file_exists(base_path('.env'))) {
            copy(base_path('.env.example'), base_path('.env'));
            $this->info('Created .env from .env.example');
        }

        $this->call('key:generate');
        $this->call('storage:link');
        $this->call('migrate', ['--force' => true]);

        if ($this->option('seed') || $this->confirm('Run database seeders now?', true)) {
            $this->call('db:seed', ['--force' => true]);
        }

        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('view:clear');

        $this->info('');
        $this->info('=== Installation Complete ===');
        $this->info('Default admin login: admin / admin123');
        $this->info('Start the dev server: php artisan serve');

        return self::SUCCESS;
    }
}

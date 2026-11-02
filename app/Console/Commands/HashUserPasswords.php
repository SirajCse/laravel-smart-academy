<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * Hashes legacy plain-text user passwords in batches.
 *
 * Replaces the CI3 manual upgrade script. Required because the
 * original CI3 implementation stored `users.password` in plain text
 * (security flaw noted in the source analysis).
 */
class HashUserPasswords extends Command
{
    protected $signature = 'smart-academy:hash-user-passwords {--dry-run : Do not write to DB}';
    protected $description = 'Upgrade legacy plain-text user passwords to bcrypt hashes.';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $users = User::whereRaw('LENGTH(password) < 60')->get();

        if ($users->isEmpty()) {
            $this->info('No legacy passwords found.');
            return self::SUCCESS;
        }

        $this->info("Found {$users->count()} users with legacy passwords.");

        foreach ($users as $user) {
            $plain = $user->password;
            if ($dry) {
                $this->line("[DRY] Would hash: {$user->username} (id={$user->id})");
                continue;
            }
            $user->password = Hash::make($plain);
            $user->save();
            $this->line("Hashed: {$user->username}");
        }

        $this->info('Done.');
        return self::SUCCESS;
    }
}

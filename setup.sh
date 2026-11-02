#!/usr/bin/env bash
# Smart Academy — one-command setup script.
# Usage: ./setup.sh
# Or: bash setup.sh

set -e

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$PROJECT_DIR"

echo "=========================================="
echo " Smart Academy - Laravel 12 Setup"
echo "=========================================="

# 1. Check PHP version
if ! command -v php &> /dev/null; then
    echo "ERROR: PHP is not installed. Please install PHP 8.2+"
    exit 1
fi

PHP_VERSION=$(php -r 'echo PHP_VERSION;')
echo "✓ PHP version: $PHP_VERSION"

if [[ ! "$PHP_VERSION" =~ ^8\.[2-9] ]]; then
    echo "WARNING: PHP 8.2+ is recommended. You have $PHP_VERSION"
fi

# 2. Check Composer
if ! command -v composer &> /dev/null; then
    echo "ERROR: Composer is not installed."
    echo "Install from: https://getcomposer.org/download/"
    exit 1
fi
echo "✓ Composer found"

# 3. Copy .env if not exists
if [ ! -f ".env" ]; then
    echo "→ Creating .env from .env.example"
    cp .env.example .env
fi

# 4. Install PHP dependencies
echo "→ Installing PHP dependencies (this may take a few minutes)..."
composer install --no-interaction --optimize-autoloader 2>&1 | tail -5

# 5. Generate application key
echo "→ Generating application key..."
php artisan key:generate --force

# 6. Create storage symlink
echo "→ Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

# 7. Set permissions
echo "→ Setting directory permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# 8. Run migrations
echo "→ Running database migrations..."
read -p "  Have you configured the database in .env? (y/N) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
    echo "→ Seeding database..."
    php artisan db:seed --force
else
    echo "  Skipping migrations. Run 'php artisan migrate --seed' after configuring .env"
fi

# 9. Clear caches
echo "→ Clearing caches..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

echo ""
echo "=========================================="
echo " ✓ Setup Complete!"
echo "=========================================="
echo ""
echo " Default Admin Login:"
echo "   URL:      http://localhost:8000/site/login"
echo "   Username: admin"
echo "   Password: admin123"
echo ""
echo " Start dev server: php artisan serve"
echo "=========================================="

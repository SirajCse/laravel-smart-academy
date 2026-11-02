<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\Services\{
    Customlib,
    AuthManager,
    RbacService,
    MailgatewayService,
    SmsgatewayService,
    MediaStorageService,
    ModuleLibService,
    StudentModuleService,
    SlugService,
    PushnotificationService,
    PaymentGatewayService,
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Facade aliases (framework defaults are auto-registered by Laravel 12).
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        foreach ([
            'Customlib'   => \App\Facades\Customlib::class,
            'Rbac'        => \App\Facades\Rbac::class,
            'Mailgateway' => \App\Facades\Mailgateway::class,
            'Smsgateway'  => \App\Facades\Smsgateway::class,
            'Media'       => \App\Facades\MediaStorage::class,
            'ModuleLib'   => \App\Facades\ModuleLib::class,
            'Slug'        => \App\Facades\Slug::class,
            'DataTables'  => \Yajra\DataTables\Facades\DataTables::class,
            'PDF'         => \Barryvdh\DomPDF\Facade\Pdf::class,
            'Excel'       => \Maatwebsite\Excel\Facades\Excel::class,
            'Captcha'     => \Mews\Captcha\Facades\Captcha::class,
            'Activity'    => \Spatie\Activitylog\Facades\Activity::class,
            'Socialite'   => \Laravel\Socialite\Facades\Socialite::class,
        ] as $alias => $class) {
            if (class_exists($class)) {
                $loader->alias($alias, $class);
            }
        }

        // Bind the legacy Customlib "god class" as a singleton —
        // replaces the old CI3 $this->customlib.
        $this->app->singleton(Customlib::class, fn ($app) => new Customlib($app));

        // Other service bindings (one per legacy CI3 library).
        $this->app->singleton(AuthManager::class);
        $this->app->singleton(RbacService::class);
        $this->app->singleton(MailgatewayService::class);
        $this->app->singleton(SmsgatewayService::class);
        $this->app->singleton(MediaStorageService::class);
        $this->app->singleton(ModuleLibService::class);
        $this->app->singleton(StudentModuleService::class);
        $this->app->singleton(SlugService::class);
        $this->app->singleton(PushnotificationService::class);
        $this->app->singleton(PaymentGatewayService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ─── View composers ────────────────────────────────────────
        View::composer('layouts.admin',    \App\Http\ViewComposers\AdminLayoutComposer::class);
        View::composer('layouts.student',  \App\Http\ViewComposers\StudentLayoutComposer::class);
        View::composer('layouts.front',    \App\Http\ViewComposers\FrontLayoutComposer::class);
        // Also compose all front.* and auth.* views that depend on the layout variables
        View::composer(['front.*', 'auth.*', 'errors.*'], \App\Http\ViewComposers\FrontLayoutComposer::class);

        // ─── Blade custom directives ────────────────────────────────
        // Port of:  if($this->rbac->hasPrivilege($cat, $perm))
        Blade::if('can', function (string $permission) {
            return app(RbacService::class)->hasPermission($permission);
        });

        Blade::if('role', function (string $role) {
            return app(RbacService::class)->hasRole($role);
        });

        // Port of:  $this->customlib->getLanguageList()
        Blade::directive('lang_name', function (string $code) {
            return "<?php echo \\App\\Helpers\\custom_helper\\getLanguageName({$code}); ?>";
        });

        // ─── Custom Blade components namespace ─────────────────────
        Blade::componentNamespace('App\\View\\Components', 'smart');
    }
}

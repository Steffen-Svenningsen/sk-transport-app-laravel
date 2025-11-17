<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Login;
use App\Livewire\TaskShortcut;
use Filament\Actions\Action;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchFieldKeyBindingSuffix()
            ->spa()
            ->brandLogo(asset('SK_Transport_Logo.png'))
            ->brandLogoHeight('2.5rem')
            ->defaultThemeMode(ThemeMode::Light)
            ->colors([
                'primary' => Color::Red,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                AccountWidget::class,
                TaskShortcut::class,
            ])
            ->plugins([
                FilamentEditProfilePlugin::make()
                    ->shouldShowBrowserSessionsForm(false)
                    ->shouldShowMultiFactorAuthentication(true)
                    ->setIcon('heroicon-o-user-circle')
                    ->setTitle(fn (): string => __('My Profile'))
                    ->slug('my-profile')
                    ->setNavigationLabel(fn (): string => __('My Profile'))
                    ->setNavigationGroup(fn (): string => __('Account')),
            ])
            ->userMenuItems([
                'profile' => Action::make('profile')
                    ->label(fn () => Auth::user()->name)
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-o-user-circle'),
            ])
            ->navigationItems([
                NavigationItem::make()
                    ->label(fn (): string => __('Go to App'))
                    ->url('/')
                    ->icon('heroicon-o-globe-alt')
                    ->group(fn (): string => __('Account')),
            ])
            ->navigationGroups([
                'Operations' => NavigationGroup::make(fn () => __('Operations')),
                'Invoice' => NavigationGroup::make(fn () => __('Invoice')),
                'Resources' => NavigationGroup::make(fn () => __('Resources')),
                'Account' => NavigationGroup::make(fn () => __('Account')),
            ])
            ->multiFactorAuthentication([
                AppAuthentication::make(),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}

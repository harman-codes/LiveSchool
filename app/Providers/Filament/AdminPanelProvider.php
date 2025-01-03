<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\CalendarViewOnlyWidget;
use App\Filament\Widgets\CalendarWidget;
use App\Filament\Widgets\FullSchoolAttendanceChart;
use App\Filament\Widgets\SelectedClassAttendanceChart;
use App\Livewire\TopbarSessionyearSelectorForSchool;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile(isSimple: false)
            ->colors([
                'primary' => Color::Sky,
            ])
            ->sidebarWidth('14rem') //15rem
            ->sidebarCollapsibleOnDesktop()
//            ->collapsedSidebarWidth('5rem')
            ->viteTheme('resources/css/app.css')
            ->spa()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
//                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
//            ->widgets([
//                CalendarWidget::class,
//                FullSchoolAttendanceChart::class,
//                SelectedClassAttendanceChart::class,
//                CalendarViewOnlyWidget::class,
//            ])
            ->plugins([
                FilamentFullCalendarPlugin::make()
                    ->selectable()
                    ->editable(),
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
            ]);
    }

//    public function boot()
//    {
//        FilamentView::registerRenderHook(
//            PanelsRenderHook::USER_MENU_BEFORE,
//            fn (): View => view('livewire.topbar-sessionyear-selector-for-school'),
//        );
//    }
}

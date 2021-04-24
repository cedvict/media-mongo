<?php

namespace Cedvict\MediaLibrary;

use Illuminate\Support\ServiceProvider;
use Cedvict\MediaLibrary\Conversions\Commands\RegenerateCommand;
use Cedvict\MediaLibrary\MediaCollections\Commands\CleanCommand;
use Cedvict\MediaLibrary\MediaCollections\Commands\ClearCommand;
use Cedvict\MediaLibrary\MediaCollections\Filesystem;
use Cedvict\MediaLibrary\MediaCollections\MediaRepository;
use Cedvict\MediaLibrary\MediaCollections\Models\Observers\MediaObserver;
use Cedvict\MediaLibrary\ResponsiveImages\TinyPlaceholderGenerator\TinyPlaceholderGenerator;
use Cedvict\MediaLibrary\ResponsiveImages\WidthCalculator\WidthCalculator;

class MediaLibraryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPublishables();

        $mediaClass = config('media-libraryc.media_model');

        $mediaClass::observe(new MediaObserver());

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'media-libraryc');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/media-libraryc.php', 'media-libraryc');

        $this->app->singleton(MediaRepository::class, function () {
            $mediaClass = config('media-libraryc.media_model');

            return new MediaRepository(new $mediaClass);
        });

        $this->registerCommands();
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__.'/../config/media-libraryc.php' => config_path('media-libraryc.php'),
        ], 'config');

        if (! class_exists('CreateMediaTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_media_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_media_table.php'),
            ], 'migrations');
        }

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/media-libraryc'),
        ], 'views');
    }

    protected function registerCommands(): void
    {
        $this->app->bind(Filesystem::class, Filesystem::class);
        $this->app->bind(WidthCalculator::class, config('media-libraryc.responsive_images.width_calculator'));
        $this->app->bind(TinyPlaceholderGenerator::class, config('media-libraryc.responsive_images.tiny_placeholder_generator'));

        $this->app->bind('command.media-libraryc:regenerate', RegenerateCommand::class);
        $this->app->bind('command.media-libraryc:clear', ClearCommand::class);
        $this->app->bind('command.media-libraryc:clean', CleanCommand::class);

        $this->commands([
            'command.media-libraryc:regenerate',
            'command.media-libraryc:clear',
            'command.media-libraryc:clean',
        ]);
    }
}

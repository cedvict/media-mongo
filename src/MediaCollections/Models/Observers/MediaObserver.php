<?php

namespace Cedvict\MediaLibrary\MediaCollections\Models\Observers;

use Cedvict\MediaLibrary\Conversions\FileManipulator;
use Cedvict\MediaLibrary\MediaCollections\Filesystem;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Application;

class MediaObserver
{
    public function creating(Media $media)
    {
        if ($media->shouldSortWhenCreating()) {
            if (is_null($media->order_column)) {
                $media->setHighestOrderNumber();
            }
        }
    }

    public function updating(Media $media)
    {
        /** @var \Cedvict\MediaLibrary\MediaCollections\Filesystem $filesystem */
        $filesystem = app(Filesystem::class);

        if (config('media-libraryc.moves_media_on_update')) {
            $filesystem->syncMediaPath($media);
        }

        if ($media->file_name !== $media->getOriginal('file_name')) {
            $filesystem->syncFileNames($media);
        }
    }

    public function updated(Media $media)
    {
        if (is_null($media->getOriginal('model_id'))) {
            return;
        }

        $original = $media->getOriginal('manipulations');

        if (!$this->isLaravel7orHigher()) {
            $original = json_decode($original, true);
        }

        if ($media->manipulations !== $original) {
            $eventDispatcher = Media::getEventDispatcher();
            Media::unsetEventDispatcher();

            /** @var \Cedvict\MediaLibrary\Conversions\FileManipulator $fileManipulator */
            $fileManipulator = app(FileManipulator::class);

            $fileManipulator->createDerivedFiles($media);

            Media::setEventDispatcher($eventDispatcher);
        }
    }

    public function deleted(Media $media)
    {
        if (in_array(SoftDeletes::class, class_uses_recursive($media))) {
            if (!$media->isForceDeleting()) {
                return;
            }
        }

        /** @var \Cedvict\MediaLibrary\MediaCollections\Filesystem $filesystem */
        $filesystem = app(Filesystem::class);

        $filesystem->removeAllFiles($media);
    }

    private function isLaravel7orHigher(): bool
    {
        if (Application::VERSION === '7.x-dev') {
            return true;
        }

        if (version_compare(Application::VERSION, '7.0', '>=')) {
            return true;
        }

        return false;
    }
}

<?php

namespace Cedvict\MediaLibrary;

use Cedvict\MediaLibrary\Conversions\Conversion;
use Cedvict\MediaLibrary\MediaCollections\FileAdder;
use Cedvict\MediaLibrary\MediaCollections\Models\Collections\MediaCollection as MediaCollectionModel;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illumante\Support\Collection;

interface HasMedia
{
    public function media(): MorphMany;

    /**
     * Move a file to the media library.
     *
     * @param string|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return \Cedvict\MediaLibrary\MediaCollections\FileAdder
     */
    public function addMedia($file): FileAdder;

    /**
     * Copy a file to the media library.
     *
     * @param string|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return \Cedvict\MediaLibrary\MediaCollections\FileAdder
     */
    public function copyMedia($file): FileAdder;

    public function hasMedia(string $collectionMedia = ''): bool;

    /**
     * Get media collection by its collectionName.
     *
     * @param string         $collectionName
     * @param array|callable $filters
     *
     * @return MediaCollectionModel
     */
    public function getMedia(string $collectionName = 'default', $filters = []): MediaCollectionModel;

    public function clearMediaCollection(string $collectionName = 'default'): HasMedia;

    /**
     * Remove all media in the given collection except some.
     *
     * @param string $collectionName
     * @param \Cedvict\MediaLibrary\MediaCollections\Models\Media[]|\Illuminate\Support\Collection $excludedMedia
     *
     * @return $this
     */
    public function clearMediaCollectionExcept(string $collectionName = 'default', $excludedMedia = []): HasMedia;

    /**
     * Determines if the media files should be preserved when the media object gets deleted.
     *
     * @return bool
     */
    public function shouldDeletePreservingMedia(): bool;

    /**
     * Cache the media on the object.
     *
     * @param string $collectionName
     *
     * @return mixed
     *
     */
    public function loadMedia(string $collectionName);

    public function addMediaConversion(string $name): Conversion;

    public function registerMediaConversions(Media $media = null): void;

    public function registerMediaCollections(): void;

    public function registerAllMediaConversions(): void;
}

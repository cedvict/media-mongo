<?php

namespace Cedvict\MediaLibrary\MediaCollections;

use Cedvict\MediaLibrary\HasMedia;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Closure;
use Illuminate\Database\Eloquent\Collection as DbCollection;
use Illuminate\Support\Arr;
use Jenssegers\Mongodb\Collection;

class MediaRepository
{
    protected Media $model;

    public function __construct(Media $model)
    {
        $this->model = $model;
    }

    /**
     * Get all media in the collection.
     *
     * @param \Cedvict\MediaLibrary\HasMedia $model
     * @param string $collectionName
     * @param array|callable $filter
     *
     * @return \Jenssegers\Mongodb\Collection
     */
    public function getCollection(HasMedia $model, string $collectionName, $filter = []): Collection
    {
        return $this->applyFilterToMediaCollection($model->loadMedia($collectionName), $filter);
    }

    /**
     * Apply given filters on media.
     *
     * @param \Jenssegers\Mongodb\Collection $media
     * @param array|callable $filter
     *
     * @return \Jenssegers\Mongodb\Collection
     */
    protected function applyFilterToMediaCollection(Collection $media, $filter): Collection
    {
        if (is_array($filter)) {
            $filter = $this->getDefaultFilterFunction($filter);
        }

        return $media->filter($filter);
    }

    public function all(): DbCollection
    {
        return $this->model->all();
    }

    public function getByModelType(string $modelType): DbCollection
    {
        return $this->model->where('model_type', $modelType)->get();
    }

    public function getByIds(array $ids): DbCollection
    {
        return $this->model->whereIn($this->model->getKeyName(), $ids)->get();
    }

    public function getByModelTypeAndCollectionName(string $modelType, string $collectionName): DbCollection
    {
        return $this->model
            ->where('model_type', $modelType)
            ->where('collection_name', $collectionName)
            ->get();
    }

    public function getByCollectionName(string $collectionName): DbCollection
    {
        return $this->model
            ->where('collection_name', $collectionName)
            ->get();
    }

    protected function getDefaultFilterFunction(array $filters): Closure
    {
        return function (Media $media) use ($filters) {
            foreach ($filters as $property => $value) {
                if (! Arr::has($media->custom_properties, $property)) {
                    return false;
                }

                if (Arr::get($media->custom_properties, $property) !== $value) {
                    return false;
                }
            }

            return true;
        };
    }
}

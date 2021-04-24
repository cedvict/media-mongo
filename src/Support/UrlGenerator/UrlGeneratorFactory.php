<?php

namespace Cedvict\MediaLibrary\Support\UrlGenerator;

use Cedvict\MediaLibrary\Conversions\ConversionCollection;
use Cedvict\MediaLibrary\MediaCollections\Exceptions\InvalidUrlGenerator;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Cedvict\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

class UrlGeneratorFactory
{
    public static function createForMedia(Media $media, string $conversionName = ''): UrlGenerator
    {
        $urlGeneratorClass = config('media-libraryc.url_generator');

        static::guardAgainstInvalidUrlGenerator($urlGeneratorClass);

        /** @var \Spatie\MediaLibrary\Support\UrlGenerator\UrlGenerator $urlGenerator */
        $urlGenerator = app($urlGeneratorClass);

        $pathGenerator = PathGeneratorFactory::create();

        $urlGenerator
            ->setMedia($media)
            ->setPathGenerator($pathGenerator);

        if ($conversionName !== '') {
            $conversion = ConversionCollection::createForMedia($media)->getByName($conversionName);

            $urlGenerator->setConversion($conversion);
        }

        return $urlGenerator;
    }

    public static function guardAgainstInvalidUrlGenerator(string $urlGeneratorClass): void
    {
        if (! class_exists($urlGeneratorClass)) {
            throw InvalidUrlGenerator::doesntExist($urlGeneratorClass);
        }

        if (! is_subclass_of($urlGeneratorClass, UrlGenerator::class)) {
            throw InvalidUrlGenerator::doesNotImplementUrlGenerator($urlGeneratorClass);
        }
    }
}

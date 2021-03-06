<?php

namespace Cedvict\MediaLibrary\Conversions\Actions;

use Cedvict\MediaLibrary\Conversions\Conversion;
use Cedvict\MediaLibrary\Conversions\Events\ConversionHasBeenCompleted;
use Cedvict\MediaLibrary\Conversions\Events\ConversionWillStart;
use Cedvict\MediaLibrary\Conversions\ImageGenerators\ImageGeneratorFactory;
use Cedvict\MediaLibrary\MediaCollections\Filesystem;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Cedvict\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator;

class PerformConversionAction
{
    public function execute(
        Conversion $conversion,
        Media $media,
        string $copiedOriginalFile
    ) {
        event(new ConversionWillStart($media, $conversion, $copiedOriginalFile));

        $imageGenerator = ImageGeneratorFactory::forMedia($media);

        $copiedOriginalFile = $imageGenerator->convert($copiedOriginalFile, $conversion);

        $manipulationResult = (new PerformManipulationsAction)->execute($media, $conversion, $copiedOriginalFile);

        $newFileName = $conversion->getConversionFile($media);

        $renamedFile = $this->renameInLocalDirectory($manipulationResult, $newFileName);

        if ($conversion->shouldGenerateResponsiveImages()) {
            /** @var ResponsiveImageGenerator $responsiveImageGenerator */
            $responsiveImageGenerator = app(ResponsiveImageGenerator::class);

            $responsiveImageGenerator->generateResponsiveImagesForConversion(
                $media,
                $conversion,
                $renamedFile
            );
        }

        app(Filesystem::class)->copyToMediaLibrary($renamedFile, $media, 'conversions');

        $media->markAsConversionGenerated($conversion->getName());

        event(new ConversionHasBeenCompleted($media, $conversion));
    }

    protected function renameInLocalDirectory(
        string $fileNameWithDirectory,
        string $newFileNameWithoutDirectory
    ): string {
        $targetFile = pathinfo($fileNameWithDirectory, PATHINFO_DIRNAME).'/'.$newFileNameWithoutDirectory;

        rename($fileNameWithDirectory, $targetFile);

        return $targetFile;
    }
}

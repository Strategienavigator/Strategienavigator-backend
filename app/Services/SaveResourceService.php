<?php

namespace App\Services;

use App\Models\Save;
use App\Models\SaveResource;
use Exception;
use GdImage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SaveResourceService
{


    const HASH_FUNCTION = "sha256";

    /**
     *
     * saves the given uploaded files in the array to the database and converts images to a smaller jpeg.
     * @param Save $save the save resources the files should be related to
     * @param array $resources an array of UploadedFiles
     * @return iterable the created SaveResources
     * @throws FileNotFoundException when no uploaded file is found
     * @throws Exception if anything went wrong file image conversion
     */
    public function saveResources(Save $save, array $resources): iterable
    {

        $saveResources = [];
        $names = [];
        /** @var $resource UploadedFile */
        foreach ($resources as $resource) {
            /** @var $saveResource SaveResource */
            $saveResource = $save->saveResources()->make();
            $name = $resource->getClientOriginalName();

            $saveResource->file_name = pathinfo($name, PATHINFO_FILENAME);

            if (in_array($saveResource->file_name, $names)) {
                abort(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, "duplicated file name");
            }

            $contents = $resource->get();
            if (str_starts_with($resource->getMimeType(), "image")) {
                $contents = $this->convertToSmallerImage($contents);
            }
            $saveResource->contents = $contents;
            $saveResource->file_type = "image/jpeg";
            $saveResource->contents_hash = \hash(self::HASH_FUNCTION, $saveResource->contents);
            $saveResource->hash_function = self::HASH_FUNCTION;

            $names[] = $saveResource->file_name;
            $saveResources[] = $saveResource;
        }

        $save->saveResources()->whereIn("file_name", $names)->delete();

        return $save->saveResources()->saveMany($saveResources);
    }


    /**
     * @param string $data
     * @return string
     * @throws Exception
     */
    private function convertToSmallerImage(string $data, int $width = 200): string
    {
        /**
         * @throws Exception
         */
        $throwError = function () {
            throw new Exception("Error while converting image");
        };
        /** @var GdImage|false $image */
        $image = imagecreatefromstring($data);
        if (!$image) {
            call_user_func($throwError);
        }
        $scaledImage = imagescale($image, $width);
        imagedestroy($image);
        if (!$scaledImage) {
            call_user_func($throwError);
        }

        ob_start(null, 0, PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_REMOVABLE);
        $saveResult = imagejpeg($scaledImage, null, 70);
        imagedestroy($scaledImage);
        if (!$saveResult) {
            ob_end_clean();
            call_user_func($throwError);
        }

        return ob_get_clean();
    }

    public function deleteResources(Save $save)
    {
        $save->saveResources()->delete();
    }

}

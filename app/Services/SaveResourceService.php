<?php

namespace App\Services;

use App\Models\Save;
use App\Models\SaveResource;
use Exception;
use GdImage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class SaveResourceService
{


    const HASH_FUNCTION = "sha256";


    /**
     * @throws FileNotFoundException
     */
    public function updateResources(Save $save, array $toUpdateArray)
    {
        $toUpdateCollection = collect($toUpdateArray);
        $resourceNames = $toUpdateCollection->pluck("name");
        $uniqueNames = $resourceNames->unique();

        if ($resourceNames->count() != $uniqueNames->count()) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, "duplicated file name");
        }
        $save->saveResources()->whereNotIn("file_name", $resourceNames)->delete();

        $resources = $save->saveResources;
        $toSave = [];
        foreach ($toUpdateArray as $toCheckResource) {
            /** @var SaveResource|null $existingResource */
            $existingResource = $resources->where("file_name", $toCheckResource["name"])->first();
            $isNew = false;
            if (is_null($existingResource)) {
                $isNew = true;
                /** @var SaveResource $existingResource */
                $existingResource = $save->saveResources()->make();
                $existingResource->file_name = $toCheckResource["name"];
            }
            if (array_key_exists("file", $toCheckResource)) {
                $this->setFileData($existingResource, $toCheckResource["file"]);
                $toSave[] = $existingResource;
            } elseif ($isNew) {
                abort(Response::HTTP_UNPROCESSABLE_ENTITY, "No file was given even though no database entry was present");
            }
        }
        $save->saveResources()->saveMany($toSave);
        $save->refresh();
    }


    /**
     * @param string $data
     * @return string
     * @throws Exception
     */
    private function convertToSmallerImage(string $data, int $width = 500): string
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
        
        $scaledImage = &$image;
        if(imagesx($image) > $width){
            $scaledImage = imagescale($image, $width);
            imagedestroy($image);
        }

        if (!$scaledImage) {
            call_user_func($throwError);
        }

        ob_start(null, 0, PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_REMOVABLE);
        $saveResult = imagejpeg($scaledImage, null, 85);
        imagedestroy($scaledImage);
        if (!$saveResult) {
            ob_end_clean();
            call_user_func($throwError);
        }

        return ob_get_clean();
    }

    public function deleteResources(Collection $resources)
    {
        foreach ($resources as $resource) {
            $resource->delete();
        }
    }

    /**
     * Sets the saveResource attributes to fit the given file
     *
     * @param UploadedFile $resource
     * @param SaveResource $saveResource
     * @return void
     * @throws FileNotFoundException
     */
    private function setFileData(SaveResource $saveResource, UploadedFile $resource): void
    {
        $contents = $resource->get();
        $mimetype = $resource->getMimeType();
        if (str_starts_with($mimetype, "image")
            && $mimetype != "image/svg+xml") {
            $contents = $this->convertToSmallerImage($contents);
        }
        $saveResource->contents = $contents;
        $saveResource->file_type = $mimetype;
        $saveResource->contents_hash = \hash(self::HASH_FUNCTION, $saveResource->contents);
        $saveResource->hash_function = self::HASH_FUNCTION;
    }

}

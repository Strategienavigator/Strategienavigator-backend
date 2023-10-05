<?php

namespace App\Services;

use App\Models\Save;
use App\Models\SaveResource;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SaveResourceService
{


    const HASH_FUNCTION = "sha256";

    public function saveResources(Save $save, array $resources): iterable
    {

        $saveResources = [];
        $names = [];
        foreach ($resources as $resource) {
            /** @var $saveResource SaveResource */
            $saveResource = $save->saveResources()->make();
            /** @var $resource UploadedFile */
            $saveResource->file_type = $resource->getMimeType();
            $saveResource->contents = $resource->get();
            $saveResource->contents_hash = \hash(self::HASH_FUNCTION, $saveResource->contents);
            $saveResource->hash_function = self::HASH_FUNCTION;
            $name = $resource->getClientOriginalName();

            $saveResource->file_name = pathinfo($name, PATHINFO_FILENAME);

            if (in_array($saveResource->file_name, $names)) {
                abort(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, "duplicated file name");
            }
            $names[] = $saveResource->file_name;
            $saveResources[] = $saveResource;
        }


        $save->saveResources()->whereIn("file_name", $names)->delete();

        return $save->saveResources()->saveMany($saveResources);
    }

    public function deleteResources(Save $save) {
        $save->saveResources()->delete();
    }

}

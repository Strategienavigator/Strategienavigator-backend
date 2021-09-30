<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * overrides the getPerPage() function of the model class.
 *
 * a limit
 */
trait Limitable
{

    public $maxPerPage = 50;
    public function getPerPage()
    {
        $v = \Validator::make(["limit" => request("limit", parent::getPerPage())], [
            "limit" => ["required", "integer", "min:1", "max:$this->maxPerPage"]
        ]);
        return intval($v->validate()["limit"]);
    }


}

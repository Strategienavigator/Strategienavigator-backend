<?php


namespace App\Helper;


class PermissionHelper
{
    public static $PERMISSION_READ = 0;
    public static $PERMISSION_WRITE = 1;
    public static $PERMISSION_ADMIN = 2;

    /**
     * @param $permission int the permission which
     * @param $neededPermission int the permission which the given permission should at least have
     */
    public static function isAtLeastPermission(int $permission, int $neededPermission)
    {
        return $permission>=$neededPermission;
    }
}

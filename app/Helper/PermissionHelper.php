<?php


namespace App\Helper;

/**
 * Klasse welche Funktionen enthalten, um Rechte zu verwalten.
 */
class PermissionHelper
{
    public static $PERMISSION_READ = 0;
    public static $PERMISSION_WRITE = 1;
    public static $PERMISSION_ADMIN = 2;

    /**
     * @param $permission int the permission which
     * @param $neededPermission int the permission which the given permission should at least have
     * @return bool ob die zu prüfende Berechtigung, mindestens oder eine höhere Berechtigung ist.
     */
    public static function isAtLeastPermission(int $permission, int $neededPermission): bool
    {
        return $permission >= $neededPermission;
    }
}

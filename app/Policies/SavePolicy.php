<?php

namespace App\Policies;

use App\Broadcasting\SaveChannel;
use App\Helper\PermissionHelper;
use App\Models\Save;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SavePolicy
{
    use HandlesAuthorization;

    /**
     * Im Debug-Modus haben alle User zugriff alle Speicherstände anzuschauen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @return boolean Ob der User alle Speicherstände anschauen darf
     */
    public function viewAny(User $user): bool
    {
        return config("app.debug"); // TODO change to false
    }

    /**
     * Wenn der User Leseberechtigung auf den Speicherstand hat, kann er sie Anschauen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Save $save Der Speichstand, welcher angeschaut werden soll
     * @return boolean Ob der User den Speicherstand anschauen darf
     */
    public function view(User $user, Save $save): bool
    {
        return $save->hasAtLeasPermission($user, PermissionHelper::$PERMISSION_READ);
    }

    /**
     * Alle User dürfen einen Speicherstand erstellen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @return boolean Ob der User einen Speicherstand erstellen darf
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Alle User die Schreibberechtigungen auf den Speicherstand haben, können den Speicherstand ändern
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Save $save Der Speicherstand, welcher bearbeitet wird
     * @return boolean Ob der User den Speicherstand bearbeiten darf
     */
    public function update(User $user, Save $save): bool
    {
        return $save->hasAtLeasPermission($user, PermissionHelper::$PERMISSION_WRITE);
    }

    /**
     * Wenn der User Adminberechtigungen hat, kann er den Speicherstand löschen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Save $save Der Speicherstand, welcher gelöscht werden soll
     * @return boolean Ob der User den Speicherstand löschen darf
     */
    public function delete(User $user, Save $save): bool
    {
        return $save->hasAtLeasPermission($user, PermissionHelper::$PERMISSION_ADMIN);
    }

    /**
     * Kein User darf einen Speicherstand wiederherstellen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Save $save Der Speicherstand, welcher wiederhergestellt werden soll
     * @return boolean Ob der User den Speicherstand wiederherstellen darf
     */
    public function restore(User $user, Save $save): bool
    {
        //TODO
        return false;
    }

    /**
     * Wenn der User broadcasten darf
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Save $save Der Speicherstand
     * @return bool
     */
    public function broadcast(User $user, Save $save): bool {
        return (new SaveChannel())->join($user, $save) !== false;
    }

    /**
     * Kein User darf einen Speicherstand komplett löschen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Save $save Der Speicherstand, welcher komplett gelöscht werden soll
     * @return boolean Ob der User den Speicherstand komplett löschen darf
     */
    public function forceDelete(User $user, Save $save): bool
    {
        //TODO
        return false;
    }
}

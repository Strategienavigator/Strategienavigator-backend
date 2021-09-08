<?php

namespace App\Policies;

use App\Models\Tool;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToolPolicy
{
    use HandlesAuthorization;

    /**
     * Jeder darf alle Tools anschauen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @return boolean Ob der user alle Tools ansehen darf
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Alle User dürfen alle Tools ansehen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Tool $tool Das Tool
     * @return boolean Ob der User das Tool ansehen darf
     */
    public function view(User $user, Tool $tool): bool
    {
        return true;
    }

    /**
     * Keiner Darf ein Tool erstellen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @return boolean Ob der User ein Tool erstellen darf
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Keiner Darf ein Tool bearbeiten
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Tool $tool Das Tool
     * @return boolean Ob der User das Tool bearbeiten darf
     */
    public function update(User $user, Tool $tool): bool
    {
        return false;
    }

    /**
     * Keiner Darf ein Tool löschen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Tool $tool Das Tool
     * @return boolean Ob der User das Tool löschen darf
     */
    public function delete(User $user, Tool $tool): bool
    {
        return false;
    }

    /**
     * Keiner Darf ein Tool wieder herstellen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Tool $tool Das Tool
     * @return boolean Ob der User das Tool wieder herstellen darf
     */
    public function restore(User $user, Tool $tool): bool
    {
        return false;
    }

    /**
     * Keiner Darf ein Tool komplett Löschen
     *
     * @param User $user Der aktuelle authentifizierte User
     * @param Tool $tool Das Tool
     * @return boolean Ob der User das Tool komplett Löschen darf
     */
    public function forceDelete(User $user, Tool $tool): bool
    {
        return false;
    }
}

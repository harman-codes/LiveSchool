<?php

namespace App\Policies;

use App\Helpers\Role;
use App\Models\User;

class LibraryPolicy
{
    private $is_allowed;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        $this->is_allowed = Role::isAdminOrManagementOrPrincipalOrManager() || Role::isLibrarian();
    }

    public function create(): bool
    {
        return $this->is_allowed;
    }

    public function update(): bool
    {
        return $this->is_allowed;
    }

    public function delete(): bool
    {
        return $this->is_allowed;
    }
}

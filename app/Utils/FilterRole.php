<?php

namespace App\Utils;

use App\Models\User;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

class FilterRole
{
    public static function filterByRole(CrudPanel $crud, $entry): void
    {
        $user = User::find(backpack_user()->id);
        if (!$user->hasRole($entry . ".list")) {
            $crud->denyAccess(["list"]);
        }
        if (!$user->hasRole($entry . ".create")) {
            $crud->denyAccess(["create"]);
        }
        if (!$user->hasRole($entry . ".update")) {
            $crud->denyAccess(["update", "show", "edit", "delete"]);
        }
    }

}

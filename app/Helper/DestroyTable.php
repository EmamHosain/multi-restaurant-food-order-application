<?php

namespace App\Helper;
use Spatie\Permission\Models\Permission;

class DestroyTable
{

    public function destroy()
    {
        $permissions = Permission::all();

        foreach ($permissions as $item) {
            $item->delete();
        }

    }
}

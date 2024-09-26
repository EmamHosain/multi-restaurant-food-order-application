<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Models\Permission;

class PermissionImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Permission([
            'guard_name' => $row[0],
            'group_name' => $row[1],
            'name' => $row[2],
        ]);
    }
}

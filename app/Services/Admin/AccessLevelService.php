<?php

namespace App\Services\Admin;

use App\Models\AccessLevel;
use Illuminate\Database\Eloquent\Model;

class AccessLevelService
{
    public function createAccessLevel(array $data): Model|AccessLevel
    {
        return AccessLevel::create($data);
    }

    public function updateAccessLevel(AccessLevel $accessLevel, array $data): AccessLevel
    {
        $accessLevel->update($data);
        return $accessLevel->refresh();
    }
}

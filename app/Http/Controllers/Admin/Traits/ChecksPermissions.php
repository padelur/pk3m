<?php

namespace App\Http\Controllers\Admin\Traits;

trait ChecksPermissions
{
    /**
     * Check if user has permission, abort if not
     */
    protected function checkPermission(string $permission): void
    {
        $user = auth()->user();
        
        if (!$user->hasPermission($permission)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }

    /**
     * Check if user has any of the given permissions
     */
    protected function checkAnyPermission(array $permissions): void
    {
        $user = auth()->user();
        
        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                return;
            }
        }
        
        abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
    }
}


<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('check_access')) {
    /**
     * Cek akses untuk role dan menu.
     *
     * @param int $role_id
     * @param int $menu_id
     * @return bool
     */
    function check_access($role_id, $menu_id)
    {
        // Contoh query untuk memeriksa akses
        return DB::table('users_access_menu')
            ->where('role_id', $role_id)
            ->where('menu_id', $menu_id)
            ->exists();
    }
}
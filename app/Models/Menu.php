<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'users_menu';
    protected $fillable =[
        'menu',
        'icon_menu'
    ];

    public function getSubMenu()
    {
        $query = "SELECT `users_sub_menu`.*, `users_menu`.`menu`
                  FROM `users_sub_menu`
                  JOIN `users_menu`
                  ON `users_sub_menu`.`menu_id` = `users_menu`.`id`
                  ORDER BY `users_sub_menu`.`id` ASC";

        return DB::select($query);
    }
}
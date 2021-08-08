<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Models\Menu;
use phpDocumentor\Reflection\Types\Self_;

class Role extends Model
{
    protected $fillable = ['title', 'alias'];

    public $relation_ids = [];
    const TYPE_STAFF = 'staff';
    const TYPE_CLIENT = 'client';
    const TYPES = [
      Self::TYPE_STAFF,
      Self::TYPE_CLIENT
    ];


    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    public function canAccessMenu($menu)
    {
        if ($menu instanceof Menu) {
            $menu = $menu->id;
        }

        if (! isset($this->relation_ids['menus'])) {
            $this->relation_ids['menus'] = $this->menus()->pluck('id')->flip()->all();
        }

        return isset($this->relation_ids['menus'][$menu]);
    }

    public static function get_role_id($alias){
        $record = \DB::table('roles')->where('alias', $alias)->first();
        if($record){
            return $record->id;
        }
        return null;
    }
}


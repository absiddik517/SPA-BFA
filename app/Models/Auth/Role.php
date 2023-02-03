<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $guarded = [];
    protected $perPage = 5;
    
    
    public function permissions(){
      return $this->hasMany(RoleHasPermission::class);
    }
}

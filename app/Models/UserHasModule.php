<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelJsonApi\Eloquent\SoftDeletes;

class UserHasModule extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'module_id'];

    protected $table = 'user_has_modules';

    public function user(){
        return $this->belongsTo(User::class);
    }
}

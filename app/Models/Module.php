<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelJsonApi\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['slug', 'title', 'route', 'icon', 'created_by', 'updated_by', 'deleted_by'];
    protected $table = 'modules'; // Your table name

    protected $guarded = [];

    public function subModule(){
        return $this->hasMany(SubModule::class);
    }
}

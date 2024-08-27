<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelJsonApi\Eloquent\SoftDeletes;

class SubModule extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['menu_order', 'module_id', 'title', 'route', 'slug', 'icon', 'created_by', 'updated_by', 'deleted_by'];
    protected $table = 'sub_modules'; // Your table name

    protected $guarded = [];
}

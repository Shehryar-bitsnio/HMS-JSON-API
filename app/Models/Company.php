<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelJsonApi\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [ 'company_name', 'company_email', 'company_phone', 'country', 'city',  'street_address', 'created_by', 'updated_by', 'deleted_by' ];
    protected $table = 'companies';

    public function users(){
        return $this->hasMany(User::class);
    }
}

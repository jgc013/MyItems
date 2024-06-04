<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        'organizationName',
    ];
    public function user()
    {
        return $this->hasMany(User::class,'id_organization');
    }
    public function item()
    {
        return $this->hasMany(Item::class,'id_organization');
    }
    public function logisticsCenter()
    {
        return $this->hasMany(LogisticsCenter::class, 'id_organization');
    }
}

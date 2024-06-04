<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_organization'
    ];
    public function logisticsCenters()
    {
        return $this->belongsToMany(LogisticsCenter::class, 'items_logistics_centers', 'id_item', 'id_logistics_center')
            ->withPivot('amount', 'location')
            ->withTimestamps();
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'id_organization');
    }
    public function movements()
    {
        return $this->hasMany(Movement::class, 'id_item');
    }
    public static function newItem($itemName)
    {
        DB::beginTransaction();

        try {
            Item::create([
                'name' => $itemName,
                'id_organization' => Auth::user()->organization->id
            ]);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public static function checkDuplicate($itemName)
    {
        return static::where("name", $itemName)->where("id_organization", Auth::user()->organization->id)->first();
    }
}

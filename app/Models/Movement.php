<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movement extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'amount',
        'id_item',
        'id_user',
        'id_logistics_center',
        'location',
    ];
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function logisticsCenter()
    {
        return $this->belongsTo(LogisticsCenter::class, 'id_logistics_center');
    }

    public static function store($movementData)
    {
        $itemLogisticsCenterData = [
            'amount' => $movementData['amount'],
            'location' => $movementData['location'],
            'id_item' => $movementData['id_item'],
            'id_logistics_center' => $movementData['id_logistics_center'],
        ];
        
        ItemsLogisticsCenters::store($itemLogisticsCenterData,$movementData);
        


    }
}

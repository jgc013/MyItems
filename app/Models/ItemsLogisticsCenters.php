<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Termwind\Components\Dd;

class ItemsLogisticsCenters extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'location',
        'id_item',
        'id_logistics_center',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item');
    }

    public function logisticCenter()
    {
        return $this->belongsTo(LogisticsCenter::class, 'id_logistic_center');
    }

    public static function store($itemLogisticsCenterData, $movementData)
    {
        try {

            $itemLogisticsCenter =  static::where("id_item", $itemLogisticsCenterData["id_item"])->where("id_logistics_center", $itemLogisticsCenterData["id_logistics_center"])->where("location", $itemLogisticsCenterData["location"])->first();

            if ($itemLogisticsCenter == null) {
                if ($movementData['type'] == "out") {
                    throw new Exception("There isn’t stock to carry out the requested movement");
                } else {
                    // dd(Movement::create($movementData));
                    static::create($itemLogisticsCenterData);
                    Movement::create($movementData);
                }
            } else {
                if ($movementData['type'] == "in") {
                    $itemLogisticsCenter->amount = $itemLogisticsCenterData["amount"] + $itemLogisticsCenter->amount;
                } elseif ($movementData['type'] == "out") {
                    if ($itemLogisticsCenter->amount - $itemLogisticsCenterData["amount"] < 0) {
                        throw new Exception("There isn’t stock to carry out the requested movement");
                    } else {
                        $result = $itemLogisticsCenter->amount - $itemLogisticsCenterData["amount"];
                        $itemLogisticsCenter->amount = $itemLogisticsCenter->amount - $itemLogisticsCenterData["amount"];
                        Movement::create($movementData);
                        
                        if($result == 0){

                            $itemLogisticsCenter->delete();
                        }else{

                            $itemLogisticsCenter->save();
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            return redirect()->route('movement.list')->withErrors([$e->getMessage()]);
        }
    }

    public static function alterAmount(Movement $movement)
    {
        try {
            $itemLogisticsCenter = static::where("id_item", $movement->id_item)->where("id_logistics_center", $movement->id_logistics_center)->where("location", $movement->location)->first();
            if ($itemLogisticsCenter == null) {
                $movement->delete();
            
            }else{
                
                if ($movement->type == "in") {
                    if ($itemLogisticsCenter->amount - $movement->amount < 0) {
                        throw new Exception("It isn’t possible to eliminate this movement");
                    } else {
    
                        $itemLogisticsCenter->amount =  $itemLogisticsCenter->amount - $movement->amount;
                        $movement->delete();
                    }
                } elseif ($movement->type == "out") {
                    $itemLogisticsCenter->amount = $itemLogisticsCenter->amount + $movement->amount;
                }
                if ($itemLogisticsCenter->amount == 0) {
                    $itemLogisticsCenter->delete();
                    $movement->delete();
                } else {
                    $itemLogisticsCenter->save();
                    $movement->delete();
                }
            }
        } catch (\Throwable $e) {

            return redirect()->route('movement.list')->withErrors([$e->getMessage(), $movement->id]);
        }
    }
}

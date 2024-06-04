<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class LogisticsCenter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_organization',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function users()
    {
        return $this->hasMany(User::class, 'id_logistics_center');
    }


    public function items()
    {
        return $this->belongsToMany(Item::class, 'items_logistics_centers', 'id_logistics_center', 'id_item')
            ->withPivot('amount', 'location')
            ->withTimestamps();
    }
    public function movements()
    {
        return $this->hasMany(Movement::class, 'id_logistics_center');
    }

    public static function newLogisticsCenter($logisticsCenterName)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            if (!$user) {
                throw new \Exception('The user is not authenticated');
            }

            $idOrganizationUser = $user->organization->id;

            logisticsCenter::create([
                'name' => $logisticsCenterName,
                'id_organization' => $idOrganizationUser
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public static function checkDuplicate($logisticsCenterName)

    {
        return static::where("name", $logisticsCenterName)->where("id", Auth::user()->organization->id)->first();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\ItemsLogisticsCenters;
use App\Models\LogisticsCenter;
use Carbon\Carbon;
use Exception;
use Termwind\Components\Dd;

class MovementController extends Controller
{
    public function list($logisticsCenter= null)
    {
        $lastMonth= Carbon::now()->subMonth();

        if (Auth::user()->rol == "employee") {
            $user = Auth::user();
            $movements =  $user->logisticsCenter->movements;
            $items = $user->organization->item;
            $result = [];
            $i = 0;
            foreach ($movements as $movement) {
                if($movement->updated_at >= $lastMonth){

                    if ($movement->type == 'in') {
                        $result[$i]["type"] = "Input";
                    } else {
                        $result[$i]["type"] = "Output";
                    }
                    $result[$i]["name"] = Item::find($movement->id_item)->name;
                    $result[$i]["amount"] = $movement->amount;
                $result[$i]["updatedAt"] = date('Y-m-d', $movement->updated_at->timestamp);
                $result[$i]["user"] = User::find($movement->id_user)->user;
                $result[$i]["id"] = $movement->id;
                $i++;
            }
            }

            return view('movement', [
                'movements' => $result,
                'items' => $items,
                'logisticsCenter' =>$user->logisticsCenter,
                'view' => "movements"
            ]);
        } else {
            $result = [];
            $i = 0;
            foreach (LogisticsCenter::find($logisticsCenter)->movements as $movement) {
                if($movement->updated_at >= $lastMonth){

                if ($movement->type == 'in') {
                    $result[$i]["type"] = "Input";
                } else {
                    $result[$i]["type"] = "Output";
                }
                $result[$i]["name"] = Item::find($movement->id_item)->name;
                $result[$i]["amount"] = $movement->amount;
                $result[$i]["updatedAt"] = date('Y-m-d', $movement->updated_at->timestamp);
                $result[$i]["user"] = User::find($movement->id_user)->user;
                $result[$i]["id"] = $movement->id;
                $i++;
            }
            }
            return view('movement', [
                'movements' => $result,
                'logisticsCenter'=>LogisticsCenter::find($logisticsCenter),
                'view' => "movements"
            ]);
        }
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'item' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'location' => 'required|string|regex:/^\d+-\d+-\d+$/',
        ]);

        $movementData = [
            'type' => $request->type,
            'amount' => $request->amount,
            'id_item' => $request->item,
            'id_user' => Auth::user()->id,
            'id_logistics_center' => Auth::user()->logisticsCenter->id,
            'location' =>  $request->location,
        ];
        if(ItemsLogisticsCenters::where("location",$request->location)->first()){

            if (ItemsLogisticsCenters::where("location",$request->location)->first()->id_item == $request->item) {
                # code...
                Movement::store($movementData);
                return redirect()->route('movement.list');
            }else{
                throw new Exception("That location is occupied by another item");
            }
        }else{
            Movement::store($movementData);
            return redirect()->route('movement.list');

        }
        
    }
    public function delete($id): RedirectResponse
    {

        $movement = Movement::find($id);
        ItemsLogisticsCenters::alterAmount($movement);

        $movement->delete();
        return redirect()->route('movement.list');
    }
}

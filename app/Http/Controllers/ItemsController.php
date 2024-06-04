<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemsLogisticsCenters;
use App\Models\LogisticsCenter;
use App\Models\Movement;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    function list()
    {
        $items = Auth::user()->organization->item;
        if (Auth::user()->rol == "admin") {

            $lastMonth = Carbon::now()->subMonth();
            $result = [];
            foreach ($items as  $item) {
                $result[$item->id]["name"] = $item->name;
                $movements = Movement::where("id_item", $item->id)->get();
                foreach ($movements as $movement) {
                    if ($movement->created_at >= $lastMonth) {
                        if ($movement->type == "in") {
                            if (isset($result[$item->id]["in"])) {

                                $result[$item->id]["in"] = $movement->amount +  $result[$item->id]["in"];
                            } else {

                                $result[$item->id]["in"] = $movement->amount;
                            }
                        } else {
                            if (isset($result[$item->id]["out"])) {

                                $result[$item->id]["out"] = $movement->amount +  $result[$item->id]["out"];
                            } else {

                                $result[$item->id]["out"] = $movement->amount;
                            }
                        }
                    }
                }
                $stock = ItemsLogisticsCenters::where("id_item", $item->id)->get();
                foreach ($stock as $value) {
                    if (isset($result[$item->id]["amount"])) {

                        $result[$item->id]["amount"] = $value->amount +  $result[$item->id]["amount"];
                    } else {

                        $result[$item->id]["amount"]=$value->amount;
                    }
                }
            }
            return view('items', [
                'items' => $result
            ]);
        }else{
            return view('items', [
                'items' => $items
            ]);

        }

        

    }
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate(['name' => 'required|string|max:255']);
            if (Item::checkDuplicate($request->name)) {
                throw new Exception("The name has already been taken");
            }
            Item::newItem($request->name);
            return redirect()->route('items.list');
        } catch (\Throwable $e) {

            return redirect()->route('items.list')->withErrors([$e->getMessage()]);
        }
    }
    public function destroy(Request $request): RedirectResponse
    {
        $item = Item::where('id', $request->id)->first();

        $item->logisticsCenters()->detach();
        $item->movements()->delete();
        $item->delete();


        return redirect()->route('items.list');
    }
    public function edit(Request $request): RedirectResponse
    {


        try {

            $request->validate(['name' => 'required|string|max:255']);


            if (Item::checkDuplicate($request->name)) {
                throw new Exception("The name has already been taken");
            }
            $item = item::where('id', $request->id)->first();

            $item->name = $request->name;
            $item->save();
            return redirect()->route('items.list');
        } catch (\Throwable $e) {
            return redirect()->route('items.list')->withErrors([$e->getMessage(), $request->id]);
        }
    }
    public function search(Request $request)
    {
        $search = $request->input("search");
        $result = Item::where("name", "like", "%" . $search . "%")->where("id_organization", Auth::user()->id_organization)->get();

        return response()->json($result);
    }

    public function locate(Request $request)
    {
        $items = Auth::user()->organization->item;
        if (isset($request->amount)) {
            $result = "";
            $item = ItemsLogisticsCenters::where("id_item", $request->item)->where("amount", ">=", $request->amount)->where("id_logistics_center", Auth::user()->logisticsCenter->id)->first();
            if ($item == null) {
                $result = [
                    "title" => "Amount of Item not recorded",
                    "p" => "There isn’t location with " . $request->amount . " " . Item::find($request->item)->name . "s in " . Auth::user()->logisticsCenter->name
                ];
            } else {
                $result = [
                    "title" => "Amount of item found",
                    "p" => $item->location
                ];
            }
            return view('locateItem', [
                'items' => $items,
                'result' => $result
            ]);
        } else {

            return view('locateItem', [
                'items' => $items
            ]);
        }
    }
    public function listDashboard()
    {
        $logisticsCenters = LogisticsCenter::where("id_organization", Auth::user()->organization->id)->get();
        $result = [];
        foreach ($logisticsCenters as $logisticsCenter) {
            $itemsLogisticCenter = $logisticsCenter->items;
            
            foreach ($itemsLogisticCenter as  $itemLogisticCenter) {
                if (isset($result[LogisticsCenter::find($itemLogisticCenter->pivot->id_logistics_center)->name][Item::find($itemLogisticCenter->pivot->id_item)->name])) {

                    $result[LogisticsCenter::find($itemLogisticCenter->pivot->id_logistics_center)->name][Item::find($itemLogisticCenter->pivot->id_item)->name] = $itemLogisticCenter->pivot->amount + $result[LogisticsCenter::find($itemLogisticCenter->pivot->id_logistics_center)->name][Item::find($itemLogisticCenter->pivot->id_item)->name];
                } else {
                    $result[LogisticsCenter::find($itemLogisticCenter->pivot->id_logistics_center)->name][Item::find($itemLogisticCenter->pivot->id_item)->name] = $itemLogisticCenter->pivot->amount;
                }
            }
        }
        $result2 = [];
        $logisticsCenters = LogisticsCenter::where("id_organization", Auth::user()->organization->id)->get();
        $lastMonth = Carbon::now()->subMonth();
        foreach ($logisticsCenters as $logisticsCenter) {
            $movements = $logisticsCenter->movements;
            
            foreach ($movements as $movement) {
                if ($movement->created_at >= $lastMonth) {
                    if (isset($result2[User::find($movement->id_user)->user][$movement->type])) {

                        $result2[User::find($movement->id_user)->user][$movement->type] = $movement->amount + $result2[User::find($movement->id_user)->user][$movement->type];
                    } else {
                        $result2[User::find($movement->id_user)->user][$movement->type] = $movement->amount;
                    }
                    $result2[User::find($movement->id_user)->user]["logisticCenter"] = $logisticsCenter->name;
                }
            }
        }
        return view('dashboard', [
            "itemsLogisticCenter" => $result,
            "movements" => $result2
        ]);
    }
}

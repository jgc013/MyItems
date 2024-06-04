<?php

namespace App\Http\Controllers;

use App\Models\ItemsLogisticsCenters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\LogisticsCenter;
use App\Models\Movement;
use Carbon\Carbon;
use Exception;

class LogisticsCentersController extends Controller
{
    public function list()
    {
        $lastMonth = Carbon::now()->subMonth();
        $user = Auth::user();
        $organizationUser = $user->organization;
        $logisticsCentersUser = $organizationUser->logisticsCenter;
        $result = [];
        foreach ($logisticsCentersUser  as $logisticsCenterUser) {
            $movements = Movement::where("id_logistics_center",$logisticsCenterUser->id)->get();
            foreach ($movements as $movement) {
                if ($movement->created_at >= $lastMonth) {
                    if ($movement->type == "in") {
                        if (isset($result[$logisticsCenterUser->id]["in"])) {

                            $result[$logisticsCenterUser->id]["in"] = $movement->amount +  $result[$logisticsCenterUser->id]["in"];
                        } else {

                            $result[$logisticsCenterUser->id]["in"] = $movement->amount;
                        }
                    } else {
                        if (isset($result[$logisticsCenterUser->id]["out"])) {

                            $result[$logisticsCenterUser->id]["out"] = $movement->amount +  $result[$logisticsCenterUser->id]["out"];
                        } else {

                            $result[$logisticsCenterUser->id]["out"] = $movement->amount;
                        }
                    }
                }
            }
            $result[$logisticsCenterUser->id]["name"]=$logisticsCenterUser->name;
            $stock = ItemsLogisticsCenters::where("id_logistics_center", $logisticsCenterUser->id)->get();
                foreach ($stock as $value) {
                    if (isset($result[$logisticsCenterUser->id]["amount"])) {

                        $result[$logisticsCenterUser->id]["amount"] = $value->amount +  $result[$logisticsCenterUser->id]["amount"];
                    } else {

                        $result[$logisticsCenterUser->id]["amount"]=$value->amount;
                    }
                }
        }
        return view('logisticsCenters', [
            'logisticsCentersUser' => $result
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        try {
            $request->validate(['name' => 'required|string|max:255']);
            if (LogisticsCenter::checkDuplicate($request->name)) {
                throw new Exception("The name has already been taken");
            }
            LogisticsCenter::newLogisticsCenter($request->name);
            return redirect()->route('logisticsCenters.list');
        } catch (\Throwable $e) {
            return redirect()->route('logisticsCenters.list')->withErrors([$e->getMessage(), $request->id]);
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        $logisticsCenter = LogisticsCenter::where('id', $request->id)->first();
        $logisticsCenter->items()->detach();
        $logisticsCenter->movements()->delete();
        $logisticsCenter->users()->delete();
        $logisticsCenter->delete();
        return redirect()->route('logisticsCenters.list');
    }
    public function edit(Request $request): RedirectResponse
    {
        try {
            $request->validate(['name' => 'required|string|max:255']);
            if (LogisticsCenter::checkDuplicate($request->name)) {
                throw new Exception("The name has already been taken");
            }
            $logisticsCenter = LogisticsCenter::where('id', $request->id)->first();
            $logisticsCenter->name = $request->name;
            $logisticsCenter->save();
            return redirect()->route('logisticsCenters.list');
        } catch (\Throwable $e) {
            return redirect()->route('logisticsCenters.list')->withErrors([$e->getMessage(), $request->id]);
        }
    }
}

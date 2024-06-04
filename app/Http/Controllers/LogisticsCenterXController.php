<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\LogisticsCenter;
use App\Models\Movement;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;

class LogisticsCenterXController extends Controller
{
    public function init($id)
    {
        $result = [];
        
        $logisticsCenter = LogisticsCenter::where("id", $id)->first();

        $lastMonth = Carbon::now()->subMonth();

        $users = $logisticsCenter->users;
        foreach ($users as $user) {
            $movements =  Movement::where("id_user", $user->id)->get();
            foreach ($movements as $movement) {
                if ($movement->created_at >= $lastMonth) {
                    if ($movement->type == "in") {
                        if (isset($result[$user->id]["in"])) {

                            $result[$user->id]["in"] = $movement->amount +  $result[$user->id]["in"];
                        } else {

                            $result[$user->id]["in"] = $movement->amount;
                        }
                    } else {
                        if (isset($result[$user->id]["out"])) {

                            $result[$user->id]["out"] = $movement->amount +  $result[$user->id]["out"];
                        } else {

                            $result[$user->id]["out"] = $movement->amount;
                        }
                    }
                }
            }
            $result[$user->id]["user"] = $user->user;
        }
        return view('logisticsCenterXstaff', ['logisticsCenter' => $logisticsCenter, "users" => $result]);

    }
    public function reports($id, Request $request)
    {
        $logisticsCenter = LogisticsCenter::where("id", $id)->first();
        $result = [];
        foreach ($logisticsCenter->items as  $item) {
            $result[$item->id] = $item->name;
        }

        return view('logisticsCenterXreports', ['logisticsCenter' => $logisticsCenter, 'items' => $result, 'users' => $logisticsCenter->users]);
    }


    public function createReport(Request $request)
    {
        $id = $request->id;
        $item1 = $request->item1;
        $item2 = $request->item2;
        $dateFrom = $request->from;
        $dateTo = $request->to;

        $logisticsCenter = LogisticsCenter::find($id);
        $dates = $this->getDateRange($dateFrom, $dateTo);
        $allMovements = $logisticsCenter->movements;

        if (is_numeric($item2) || $item2 == "allItems") {
            $result = $this->generateReportForItems($logisticsCenter, $item1, $item2, $dates, $allMovements);
        } else {
            $result = $this->generateReportForUsers($logisticsCenter, $item1, $item2, $dates, $allMovements);
        }
        $items = [];
        foreach ($logisticsCenter->items as  $item) {
            $items[$item->id] = $item->name;
        }

        $result["method2"] = $request->item1;

        return view('logisticsCenterXreports', ["result" => $result, 'logisticsCenter' => $logisticsCenter, 'users' => $logisticsCenter->users, 'items' => $items]);
    }

    private function getDateRange($dateFrom, $dateTo)
    {
        $interval = DateInterval::createFromDateString('1 day');
        $daterange = new DatePeriod(date_create($dateFrom), $interval, date_create($dateTo));
        $dates = [];
        foreach ($daterange as $date) {
            $dates[] = $date->format("Y-m-d");
        }
        return $dates;
    }

    private function generateReportForItems($logisticsCenter, $item1, $item2, $dates, $allMovements)
    {
        $result = [];
        $items = ($item2 == "allItems") ? $logisticsCenter->items : [Item::find($item2)];

        foreach ($items as $item) {
            $result[$item->name] = $this->calculateMovements($item->movements, $item1, $dates, $allMovements);
        }

        $result["total"] = $this->calculateTotal($result, $dates, $logisticsCenter);
        $result["method"] = "items";
        return $result;
    }

    private function generateReportForUsers($logisticsCenter, $item1, $item2, $dates, $allMovements)
    {
        $result = [];
        $users = ($item2 == "allUsers") ? $logisticsCenter->users : [User::where("user", $item2)->first()];

        foreach ($users as $user) {
            $result[$user->user] = $this->calculateMovements($user->movements, $item1, $dates, $allMovements);
        }

        $result["total"] = $this->calculateTotal($result,$dates, $logisticsCenter);
        $result["method"] = "users";
        return $result;
    }

    private function calculateMovements($movements, $item1, $dates, $allMovements)
    {
        $result = [];
        $totalAmount = 0;
        $totalAllAmount = 0;
        $totalMovements = 0;
        $totalAllMovements = 0;
        
        foreach ($dates as $date) {
            $result[$date] = ["amount" => 0, "allAmount" => 0, "movements" => 0, "allMovements" => 0];
            foreach ($movements as $movement) {
                if (date('Y-m-d', $movement->created_at->timestamp) === $date && ($movement->type == $item1 || $item1 == "movement")) {
                    $result[$date]["amount"] += $movement->amount;
                    $result[$date]["movements"]++;
                }
            }
            foreach ($allMovements as $movement) {
                if (date('Y-m-d', $movement->created_at->timestamp) === $date && ($movement->type == $item1 || $item1 == "movement")) {
                    $result[$date]["allAmount"] += $movement->amount;
                    $result[$date]["allMovements"]++;
                }
            }
            $result[$date]["percentage"] = $this->calculatePercentage($result[$date]["amount"], $result[$date]["allAmount"]);
            $result[$date]["movementsPercentage"] = $this->calculatePercentage($result[$date]["movements"], $result[$date]["allMovements"]);
            $totalAmount += $result[$date]["amount"];
            $totalAllAmount += $result[$date]["allAmount"];
            $totalMovements += $result[$date]["movements"];
            $totalAllMovements += $result[$date]["allMovements"];
        }
        $result["total"] = [
            "amount" => $totalAmount,
            "allAmount" => $totalAllAmount,
            "percentage" => $this->calculatePercentage($totalAmount, $totalAllAmount),
            "movements" => $totalMovements,
            "allMovements" => $totalAllMovements,
            "movementsPercentage" => $this->calculatePercentage($totalMovements, $totalAllMovements)
        ];
        return $result;
    }

    private function calculateTotal($result, $dates, $logisticsCenter)
    {
        $totalAmount = 0;
        $totalAllAmount = 0;
        $totalMovements = 0;
        $totalAllMovements = Movement::whereBetween('created_at',[$dates[0], $dates[count($dates)-1]])->where("id_logistics_center",$logisticsCenter->id)->count();
        $movements = Movement::whereBetween('created_at',[$dates[0], $dates[count($dates)-1]])->where("id_logistics_center",$logisticsCenter->id);
        foreach ($movements->get() as  $movement) {

            $totalAllAmount = $movement->amount + $totalAllAmount;
        }
        foreach ($result as $item => $data) {
            if ($item == "total") continue;
            $totalAmount += $data["total"]["amount"];
            $totalMovements += $data["total"]["movements"];
        }

        return [
            "amount" => $totalAmount,
            "allAmount" => $totalAllAmount,
            "percentage" => $this->calculatePercentage($totalAmount, $totalAllAmount),
            "movements" => $totalMovements,
            "allMovements" => $totalAllMovements,
            "movementsPercentage" => $this->calculatePercentage($totalMovements, $totalAllMovements)
        ];
    }

    private function calculatePercentage($amount, $allAmount)
    {
        return ($allAmount != 0) ? round(($amount * 100) / $allAmount, 2) . "%" : "0%";
    }
}

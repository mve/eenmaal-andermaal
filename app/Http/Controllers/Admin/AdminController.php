<?php

namespace App\Http\Controllers\Admin;

use App\Auction;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    /**
     * Show the admin Dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = User::getCreatedUsersLastMonth();
        $total = [];
        $created_at = [];

        foreach ($data as $dateWithUserCount) {
            array_push($total, $dateWithUserCount['total']);
            array_push($created_at, $dateWithUserCount['created_at']);
        }

        $data = [
            "total" => $total,
            "created_at" => $created_at
        ];

        return view('admin.index')->with($data);
    }

    /**
     * Show the application statistics.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function statistics(Request $request)
    {
        $file = fopen(storage_path('logs/laravel.log'), "r");

        $labelArr = [];
        $dataArr = [];
        $datasetLabelArr = [];
        while (!feof($file)) {
            $str = fgets($file);
            $matches = [];
            if (preg_match("/^\[+[^a-zA-Z]+\]+/", $str, $matches)) {
                $levelMatches = [];
                if (preg_match("/(\.+).*?(:+)/", $str, $levelMatches)) {
                    array_push($labelArr, explode(" ", str_replace("]", "", str_replace("[", "", $matches[0])))[0]);
                    array_push($datasetLabelArr, ucfirst(strtolower(str_replace(".", "", str_replace(":", "", $levelMatches[0])))));
                    array_push($dataArr, [
                        "datasetLabel" => ucfirst(strtolower(str_replace(".", "", str_replace(":", "", $levelMatches[0])))),
                        "label" => explode(" ", str_replace("]", "", str_replace("[", "", $matches[0])))[0],
                    ]);
                }
            }
        }

        $mainLabels = array_unique($labelArr);
        $datasetLabelArr = array_unique($datasetLabelArr);

        $totalErrorsArray = [];
        foreach($mainLabels as $label){
            array_push($totalErrorsArray, array_count_values(array_column($dataArr, 'label'))[$label]);
        }

        $finalDataArray = [];
        foreach ($datasetLabelArr as $datasetLabel) {
            $datasetDataArray = [];
            foreach ($mainLabels as $label) {
                $count = 0;
                foreach ($dataArr as $data) {
                    if($data["label"]==$label && $data["datasetLabel"]==$datasetLabel){
                        $count++;
                    }
                }
                array_push($datasetDataArray, $count);
            }
            switch(strtoupper($datasetLabel)){
                case "EMERGENCY":
                    $borderColor = "#EF4444";
                    break;
                case "DEBUG":
                    $borderColor = "#6B7280";
                    break;
                case "NOTICE":
                    $borderColor = "#34D399";
                    break;
                case "WARNING":
                    $borderColor = "#FCD34D";
                    break;
                case "ALERT":
                    $borderColor = "#3B82F6";
                    break;
                case "CRITICAL":
                    $borderColor = "#EC4899";
                    break;
                case "ERROR":
                    $borderColor = "#8B5CF6";
                    break;
                case "INFO":
                default:
                    $borderColor = "#c5AE91";
                    break;
            }
            array_push($finalDataArray, [
                "label" => $datasetLabel,
                "borderColor" => $borderColor,
                "data" => $datasetDataArray
            ]);
        }

        fclose($file);

        $data = [
            "datasets" => $finalDataArray,
            "total" => $totalErrorsArray,
            "labels" => $mainLabels
        ];

        return view('admin.statistics')->with($data);
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\External\BreweryService;

use Illuminate\Routing\Controller as BaseController;

class BreweryController extends BaseController {
	public function getMeta(){
		$breweryResult=BreweryService::getMeta();
		if($breweryResult["status"]!=200 && $breweryResult["status"]!=304){return response()->json(['message' => 'Brewery service Error'],$breweryResult["status"]);}
		$breweryJson=json_decode($breweryResult["content"]);
		if(!is_object($breweryJson)){return response()->json(['message' => 'Brewery service Error'],500);}
		return response(json_encode($breweryJson), 200)->header('Content-Type', 'application/json');
	}
	public function getList (Request $request){
		$per_page="15";
		$page="1";
		if ($request->has('per_page')) {$per_page=$request->per_page;}
		if ($request->has('page')) {$page=$request->page;}
		if(!preg_match('/^[0-9]{1,2}$/', $per_page)) {$per_page="15";}//in caso di input non valido viene sovrascritto il valore di default
		if($per_page<5){$per_page=5;}//in caso di input furoi dal range previsto (almeno 5 risultati, non più di 50) viene sovrascritto il valore di default
		if($per_page>50){$per_page=50;}
		if(!preg_match('/^[0-9]{1,4}$/', $page)) {$page="1";}//in caso di input non valido viene sovrascritto il valore di default
		$breweryResult=BreweryService::get($per_page, $page);
		if($breweryResult["status"]!=200 && $breweryResult["status"]!=304){return response()->json(['message' => 'Brewery service Error'],$breweryResult["status"]);}
		$breweryJson=json_decode($breweryResult["content"]);
		if(!is_array($breweryJson)){return response()->json(['message' => 'Brewery service Error'],500);}
		return response(json_encode($breweryJson), 200)->header('Content-Type', 'application/json');
	}
}

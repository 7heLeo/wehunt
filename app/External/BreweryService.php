<?php

namespace App\External;

class BreweryService
{
	public static function get($per_page, $page){
		$context = stream_context_create(['http' => ['ignore_errors' => true]]);
		$result = file_get_contents("https://api.openbrewerydb.org/v1/breweries?per_page=".$per_page."&page=".$page, false, $context);
		$status_line = $http_response_header[0];
		preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
		$status = $match[1];
		return array("status"=>$status,"content"=>trim($result));		
	}
	public static function getMeta(){
		$context = stream_context_create(['http' => ['ignore_errors' => true]]);
		$result = file_get_contents("https://api.openbrewerydb.org/v1/breweries/meta", false, $context);
		$status_line = $http_response_header[0];
		preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
		$status = $match[1];
		return array("status"=>$status,"content"=>trim($result));
	}
}
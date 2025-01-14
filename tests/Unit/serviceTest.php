<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\External\BreweryService;

class serviceTest extends TestCase
{
    public function test_the_service_is_on(): void
    {
		$BreweryResult=BreweryService::get("15","1");
		$this->assertTrue($BreweryResult["status"]==200);
    }
    public function test_the_service_returns_a_successful_response(): void
    {
		$BreweryResult=BreweryService::get("15","1");
		$BreweryJson=json_decode($BreweryResult["content"]);
		$this->assertTrue($BreweryResult["status"]==200 || $BreweryResult["status"]==304);
		$this->assertTrue(is_array($BreweryJson));
		$this->assertTrue(property_exists($BreweryJson[0],'id'));
		$this->assertTrue(property_exists($BreweryJson[0],'name'));
		$this->assertTrue(property_exists($BreweryJson[0],'brewery_type'));
		$this->assertTrue(property_exists($BreweryJson[0],'address_1'));
		$this->assertTrue(property_exists($BreweryJson[0],'address_2'));
		$this->assertTrue(property_exists($BreweryJson[0],'address_3'));
		$this->assertTrue(property_exists($BreweryJson[0],'city'));
		$this->assertTrue(property_exists($BreweryJson[0],'state_province'));
		$this->assertTrue(property_exists($BreweryJson[0],'postal_code'));
		$this->assertTrue(property_exists($BreweryJson[0],'country'));
		$this->assertTrue(property_exists($BreweryJson[0],'longitude'));
		$this->assertTrue(property_exists($BreweryJson[0],'latitude'));
		$this->assertTrue(property_exists($BreweryJson[0],'phone'));
		$this->assertTrue(property_exists($BreweryJson[0],'website_url'));
		$this->assertTrue(property_exists($BreweryJson[0],'state'));
		$this->assertTrue(property_exists($BreweryJson[0],'street'));
    }
    public function test_the_service_returns_a_successful_meta_response(): void
    {
		$BreweryResult=BreweryService::getMeta();
		$BreweryJson=json_decode($BreweryResult["content"]);
		$this->assertTrue($BreweryResult["status"]==200 || $BreweryResult["status"]==304);
		$this->assertTrue(is_object($BreweryJson));
		$this->assertTrue(property_exists($BreweryJson,'total'));
		$this->assertTrue(property_exists($BreweryJson,'page'));
		$this->assertTrue(property_exists($BreweryJson,'per_page'));
    }
} 
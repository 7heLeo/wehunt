<?php

namespace Tests\Feature;
use Illuminate\Testing\Fluent\AssertableJson;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class appTest extends TestCase
{
    public function test_login_returns_error_with_no_input(): void
    {
        $response = $this->postJson('api/user/login', []);
        $response->assertStatus(422);
    }
    public function test_login_returns_error_with_no_email(): void
    {
        $response = $this->postJson('api/user/login', [
			'password' => 'test1234',
		]);
        $response->assertStatus(422);
    }
    public function test_login_returns_error_with_no_password(): void
    {
        $response = $this->postJson('api/user/login', [
			'email' => 'test'
		]);
        $response->assertStatus(422);
    }
    public function test_login_returns_error_with_wrong_email(): void
    {
        $response = $this->postJson('api/user/login', [
			'email' => 'test',
			'password' => 'test1234',
		]);
        $response->assertStatus(403);
    }
    public function test_login_returns_error_with_wrong_password(): void
    {
        $response = $this->postJson('api/user/login', [
			'email' => 'root',
			'password' => 'test1234',
		]);
        $response->assertStatus(403);
    }
    public function test_login_returns_success(): void
    {
        $response = $this->postJson('api/user/login', [
			'email' => 'root',
			'password' => 'password',
		]);
        $response->assertStatus(200)
			->assertJson(fn (AssertableJson $json) =>
				$json->has('token'));
    }
    public function test_the_application_returns_token_error(): void
    {
		$response = $this->getJson('/api/breweries');
		$response->assertStatus(401);
    }
    public function test_the_application_returns_a_successful_response(): void
    {
        $login = $this->postJson('api/user/login', [
			'email' => 'root',
			'password' => 'password',
		]);
		$token=$login->original["token"];

		$BreweryResult=$this->getJson('/api/breweries',['authorization' => "Bearer ".$token]);
		$BreweryJson=json_decode($BreweryResult->original);
		$BreweryResult->assertStatus(200);
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
}

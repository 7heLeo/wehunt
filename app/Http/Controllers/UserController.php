<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
	public function login(Request $request){
		$validatedData = $request->validate([
			//rimossa la validazione email in quanto l'username richiesto non è in formato email
			//'email' => 'required|string|email|max:255|unique:users',
			'email' => 'required|string|max:255',
			'password' => 'required|string|min:8',
		]);
		$user = User::where('email',  $validatedData['email'])->first();
		if (! $user || ! Hash::check($validatedData["password"], $user->password)){
			return response()->json(['message' => 'Access denied'],403);
		}
		$user->tokens()->delete();
		return response()->json([
			'token' => $user->createToken('auth_token')->plainTextToken,
		]);
	}
    public function register(Request $request){
	  $validatedData = $request->validate([
			'name' => 'required|string|max:255',
			//rimossa la validazione email in quanto l'username richiesto non è in formato email
			//'email' => 'required|string|email|max:255|unique:users',
			'email' => 'required|string|max:255|unique:users',
			'password' => 'required|string|min:8',
		]);
		$user = User::create([
			'name' => $validatedData['name'],
			'email' => $validatedData['email'],
			'password' => Hash::make($validatedData['password']),
		]);
		return response()->json([
			'name' => $user->name,
			'email' => $user->email,
		]);
	}
    public function logout(Request $request){
		$request->user()->currentAccessToken()->delete();
		return response()->json([
			'message' => 'User logged out successfully'
		]);
    }
}
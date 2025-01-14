<?php
namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class CheckToken
{
	private function checkTokenOnDB(Request $request,$token){
		$check=false;
		if($request->session()->has('userToken') && $request->session()->get('userToken')==$token){$check= true;}
		return $check;
	}
    public function handle(Request $request, Closure $next)
    {
		if ($request->is('api/*')) {
			if ($request->path()!='api/user/login') {
				$token = $request->header("authorization");
				$token=str_Replace("Bearer ","",$token);
				if($token==""){
					return response('{"status":"400","error":"Missing Access Token"}', 403)->header('Content-Type', 'application/json');
				}
				if(!CheckToken::checkTokenOnDB($request,$token)){
					return response('{"status":"403","error":"Invalid Access Token"}', 403)->header('Content-Type', 'application/json');
				}
			}
		}else{
			$logged=false;
			if($request->session()->has('userToken')){$logged=true;}
			if ($request->path()=='login') {
				if($logged){
					return redirect('/');
				}
			}else{
				if(!$logged){
					return redirect('/login');
				}
			}
		}
        return $next($request);
    }
}
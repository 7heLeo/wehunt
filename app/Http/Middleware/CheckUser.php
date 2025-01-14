<?php
namespace App\Http\Middleware;
use Closure;

class CheckUser
{
	private function checkTokenOnDB($request,$token){
		$check=false;
		if($request->session()->has('userToken') && $request->session()->get('userToken')==$token){$check= true;}
		return $check;
	}
    public function handle($request, Closure $next)
    {
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
        return $next($request);
    }
}
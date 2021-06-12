<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
class PortalLoginController extends Controller
{
    //
	public function redirectToProvider()
	{
		return \Socialite::with('portal')->redirect();
	}

	public function handleProviderCallback()
	{
		$user = \Socialite::with('portal')->user();
		$id = $user['identifier'];
        //$account = User::where('email',$user->email)->first();
        
        //如果用戶為空，則新增資料到資料表中，取決於你需要哪些使用者訊息
        /*if(!$account){
            User::create([
                'email'=>$user->email,
                'name'=>$user->nickname,
                'password'=>bcrypt('githubtest')
            ]);
        }
    
         // 登入並且「記住」使用者...
        \Auth::login($account);*/
        //回到首頁
		return redirect()->to("/reader_info?id=$id");
		//return redirect()->to('/ok/$id');
		//Session::put('variableName', $id);
		//echo $_SESSION['variableName'] ;
		//dd(Session::get('variableName'));
		//\Session::set('id', $user);
		//dd(\Session::get('id'));
		// dd($user);
		// 登入成功 ... 產生一個 User 的物作, 用 Auth:login() 去讓 User 登入

        //return redirect()->to('www.google.com');
		//return redirect()->guest('auth/login');
	}
}

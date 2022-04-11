<?php
use Illuminate\Support\Facades\Auth;

//ユーザー情報の取得
if (! function_exists('userInfo')) {
    function userInfo() {
        return Auth::guard()->user();
    }
}
//ログインしているか？
if (! function_exists('isLogin')) {
    function isLogin() {
        return !empty(userInfo());
    }
}
//ユーザーの属性を取得する
if (! function_exists('getUserType')) {
    function getUserType() {
        if (isLogin()) {
            switch (get_class(userInfo())) {
                case 'App\Admin':
                    $userType = 'Admin';
                    break;
                default:
                    $userType = 'User';
            }
        } else {
            $userType = 'Guest';
        }
        return $userType;
    }
}
//現在のページが管理者用か？-> adminのRouteには'admin'のプレフィクスをつける。
if (! function_exists('isAdminRoute')) {
    function isAdminRoute() {
        return strpos(\Route::currentRouteName(), 'admin') !== false;
    }
}
if (! function_exists('isAdminLogin')) {
   function isAdminLogin() {
       return isAdminRoute() && strpos(\Route::currentRouteName(), 'login') !== false;
   }
}

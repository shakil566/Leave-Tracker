<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BrowsingHistory;
use App\Models\Configurable;
use App\Models\IpBlocker;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\LogHistory;
use Jenssegers\Agent\Agent;
Use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function validateLogin(Request $request)
    {
        // Get the user details from database and check if email is verified.
        $user = User::where('username', $request->input($this->username()))->first();
        if (!empty($user)) {
            if ($user->group_id == '6') {
                if ($user->status == '2') {
                    throw ValidationException::withMessages([$this->username() => __('label.FAILED_TO_LOGIN_USER_INACTIVE')]);
                }
                $validIp = $validIpText = '';
                $ip = $_SERVER['REMOTE_ADDR'];

                $configurable = Configurable::where(['id' => '1', 'configurable' => '1'])->first();

                $validIpInfo = IpBlocker::select('user_id', 'ip')->where('user_id', $user->id)->first();
                $validIpText = !empty($validIpInfo->ip) ? $validIpInfo->ip : 'not set yet ! ';
                if (!empty($validIpInfo->ip)) {
                    $validIp = explode(',', $validIpInfo->ip);
                }

                $authorizedUser = User::leftJoin('ip_blocker', 'ip_blocker.user_id', 'users.id')
                ->where('ip_blocker.ip', $ip)
                ->select(
                    'users.full_name as user_name',
                    'users.official_name'
                )->first();

                $authorizedUserName = 'not set yet ! ';
                if (!empty($authorizedUser)) {
                    $authorizedUserName = $authorizedUser->official_name ?? 'not set yet ! ';
                }

                if (!empty($configurable)) {
                    if (!in_array($ip, $validIp)) {
                    // if ($validIp != $ip) {
                        throw ValidationException::withMessages([
                            $this->username() => __('label.YOUR_IP_IS_NOT_AUTHORIZED_FOR_LOGIN', [
                                'your_ip' => $ip,
                                'valid_ip' => $validIpText,
                                'authorized_user' => $authorizedUserName,
                            ])
                        ]);
                    }
                }
            }
        }



        // Email is verified, validate input.
        return $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    protected function credentials(Request $request)
    {

        $data = $request->only($this->username(), 'password');
        $data['status'] = '1';
        return $data;
    }


    public function username()
    {
        return 'username';
    }


    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $userLogInfo = LogHistory::where(['user_id' => Auth::user()->id, 'login_date' => date('Y-m-d')])->where('type_id', '1')->first();
        $preLogInfo = !empty($userLogInfo->login_info) ? $userLogInfo->login_info : '';
        $preLogInfoArr = json_decode($preLogInfo, true);


        $logoutArr = [];
        if (!empty($preLogInfoArr)) {
            foreach ($preLogInfoArr as $key => $preLogInfo) {
                if ($key == Session::get('login_id')) {
                    $logoutArr[$key]['operating_system'] = $preLogInfo['operating_system'];
                    $logoutArr[$key]['browser'] = $preLogInfo['browser'];
                    $logoutArr[$key]['browser_ip'] = $preLogInfo['browser_ip'];
                    $logoutArr[$key]['login_datetime'] = $preLogInfo['login_datetime'];
                    $logoutArr[$key]['logout_datetime'] = date('Y-m-d H:i:s');
                } else {
                    $logoutArr[$key]['operating_system'] = $preLogInfo['operating_system'];
                    $logoutArr[$key]['browser'] = $preLogInfo['browser'];
                    $logoutArr[$key]['browser_ip'] = $preLogInfo['browser_ip'];
                    $logoutArr[$key]['login_datetime'] = $preLogInfo['login_datetime'];
                    $logoutArr[$key]['logout_datetime'] = $preLogInfo['logout_datetime'];
                }
            }
        }
        if (!empty($logoutArr)) {
            $finalData = json_encode($logoutArr);
            $userLogInfo->login_date = date('Y-m-d');
            $userLogInfo->login_info = $finalData;
            $userLogInfo->save();
        }


        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }


    public function authenticated(Request $request)
    {
        $request->session()->put('paginatorCount', __('label.PAGINATION_COUNT'));

        // For Log Report Start
        $agent = new Agent();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $browser_ip = $request->ip();

        $logInfo = [];
        $uniquid = uniqid();
        $request->session()->put('login_id', $uniquid);
        $logInfo[$uniquid]['operating_system'] = $platform;
        $logInfo[$uniquid]['browser'] = $browser;
        $logInfo[$uniquid]['browser_ip'] = $browser_ip;
        $logInfo[$uniquid]['login_datetime'] = date('Y-m-d H:i:s');
        $logInfo[$uniquid]['logout_datetime'] = '';
        $logInfoJson = json_encode($logInfo);


        $userLogInfo = LogHistory::where(['user_id' => Auth::user()->id, 'login_date' => date('Y-m-d')])
            ->where('type_id', '1')->first();

        if (!empty($userLogInfo->login_info)) {
            $preLogInfo = json_decode($userLogInfo->login_info, true);
        }

        if (!empty($preLogInfo)) {
            $finalLogInfoJson = array_merge($preLogInfo, $logInfo);
            $logInfoJson = json_encode($finalLogInfoJson);
            $userLogInfo->login_info = $logInfoJson;
            $userLogInfo->save();
        } else {
            $logHistory = new LogHistory;
            $logHistory->user_id = Auth::user()->id;
            $logHistory->type_id = 1;
            $logHistory->login_date = date('Y-m-d');
            $logHistory->login_info = $logInfoJson;
            $logHistory->save();
        }
        //save login history, when user logged in
        $logArr = new BrowsingHistory();
        $logArr->user_id = Auth::user()->id;
        $logArr->login_at = date('Y-m-d H:i:s');
        $logArr->login_ip = $request->ip();
        $logArr->save();
        // For Log Report Start
    }
}

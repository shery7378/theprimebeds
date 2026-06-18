<?php

namespace App\Http\Controllers\Back;

use App\{
    Models\Notification,
    Http\Controllers\Controller
};
use DB;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Constructor Method.
     *
     * Setting Authentication
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notifications(){
        return view('back.notification.index');
    }


    public function view_notification()
    {
        return view('back.notification.notification',[
            'data'=>Notification::orderby('id','desc')
        ]);

    }

    public function delete($id)
    {
        $admin = Auth::guard('admin')->user();
        $notification = Notification::findOrFail($id);
        
        if ($admin->role && strtolower($admin->role->name) == 'merchant') {
            $merchantUser = \App\Models\User::where('email', $admin->email)->first();
            if ($merchantUser && $notification->user_id == $merchantUser->id) {
                $notification->delete();
            }
        } else {
            $notification->delete();
        }
        return back()->withSuccess(__('Notification Delete Successfully.'));
    }


    /**
     * Clear a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clear_notf(){
        $admin = Auth::guard('admin')->user();
        if ($admin->role && strtolower($admin->role->name) == 'merchant') {
            $merchantUser = \App\Models\User::where('email', $admin->email)->first();
            if ($merchantUser) {
                Notification::where('user_id', $merchantUser->id)
                    ->whereIn('type', ['price_approved', 'price_rejected'])
                    ->delete();
            }
        } else {
            Notification::where(function($q) {
                $q->whereNull('type')
                  ->orWhereIn('type', ['registration', 'order', 'admin']);
            })->delete();
        }
    }

}

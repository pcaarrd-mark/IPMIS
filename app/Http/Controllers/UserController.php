<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App;
use Auth;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $users = App\Models\User::whereNull('deleted_at')->get();
        return view('admin.users')->with('user',$users);
    }

    public function create()
    {
        //CHECK UNIQUE USERNAME
        $message = false;
        $user = App\Models\User::where('username',request()->new_username)->count();
        if($user > 0)
        {
            $message .= "- Username already exist..<br>";
        }

        //PASSWORD MATCH
        if(request()->new_password != request()->new_password2)
        {
            $message .= "- Password does not match..<br>";
        } 

        if($message != '')
        {
            
            return view('admin.error')->with("message",$message);
        }

        Log::channel('audit')->info(Auth::user()->name.' - Created new user : '.request()->new_fullname." account type : ".request()->new_usertype);

        $user = new App\Models\User;
        $user->name = request()->new_fullname;
        $user->username = request()->new_username;
        $user->usertype = request()->new_usertype;
        $user->password = Hash::make(request()->new_password);
        $user->save();

        return redirect('/admin/users');
    }

    public function update()
    {
        //IF USERNAME UNIQUE
        $user = App\Models\User::get();
        $flag = false;
        foreach($user AS $users)
        {
            if($users->username == request()->edit_username && $users->id != request()->edit_user_id)
            {
                $flag = true;
            }
        }

        if($flag)
        {
            $message = "<b>'".request()->edit_username."' - ".$users->name." </b> already exist.. Username must be unique";
            return view('admin.error')->with("message",$message);
        }

        $user = App\Models\User::where('id',request()->edit_user_id)->first();

        //IF PASSWORD HAS PASSWORD CHANGE
        if(isset(request()->edit_password))
        {
                App\Models\User::where('id',request()->edit_user_id)
                            ->update([
                                        'name' => request()->edit_fullname,
                                        'username' => request()->edit_username,
                                        'usertype' => request()->edit_usertype,
                                        'password' => Hash::make(request()->edit_password),
                                    ]);
        }   
        else
        {
            App\Models\User::where('id',request()->edit_user_id)
                            ->update([
                                        'name' => request()->edit_fullname,
                                        'username' => request()->edit_username,
                                        'usertype' => request()->edit_usertype,
                                    ]);
        }

        Log::channel('audit')->info(Auth::user()->name.' - Updated user : '.$user['name']);

        return redirect('/admin/users');
    }

    public function delete()
    {
        $user = App\Models\User::where('id',request()->user_id)->first();

        Log::channel('audit')->info(Auth::user()->name.' - Deleted user : '.$user['name']);

        App\Models\User::where('id',request()->user_id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

        return redirect('admin/users');
    }

    public function json($id)
    {
        $product = App\Models\User::where('id',$id)->first()->toJson();
        return $product;
    }
}

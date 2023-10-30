<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        // $userId = Auth::user()->id;
        // $users = $model->where('id',$userId)->get();
        $users = $model->with('user_profile')->get();
        return view('users.index', compact('users'));
    }
}

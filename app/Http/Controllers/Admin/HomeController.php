<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $user = User::find(auth()->id());
        $roles = $user->getRoleNames();
//        dd($user->can('edit events'));
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }
}

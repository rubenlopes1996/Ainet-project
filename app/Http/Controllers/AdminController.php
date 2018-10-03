<?php

namespace App\Http\Controllers;

use App\User;

use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function block($id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() == $user->id) {
            abort(403);
        }
        if ($user->blocked == 1 && $user->id === $id) {
            return redirect()->route('users.index')->with('User is already Blocked!');
        }
        $user->blocked = 1;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User has been Blocked!');
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() == $user->id) {
            abort(403);
        }
        if ($user->blocked == 0 && $user->id === $id) {
            return redirect()->route('users.index')->with('User is already Unblocked!');
        }
        $user->blocked = 0;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User has been Unblocked!');
    }

    public function promote($id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() == $user->id) {
            abort(403);
        }
        if ($user->admin == 1 && $user->id === $id) {
            return redirect()->route('users.index')->with('User is already an Administrator!');
        }
        $user->admin = 1;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User has been promoted to Administrator!');
    }


    public function demote($id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() == $user->id) {
            abort(403);
        }
        if ($user->admin == 0 && $user->id === $id) {
            return redirect()->route('users.index')->with('User is already a Client!');
        }
        $user->admin = 0;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User has been demoted to Client!');
    }

    public function index(Request $request)
    {
        $name = $request->query('name', null);
        $status = $request->query('status', null);
        $type = $request->query('type', null);

        if ($name == null && empty($status) && empty($type)) {
            $users = User::all();
            return view('users.index', compact('users'));
        }

        $query = User::query();

        if ($request->input('type') == 'admin') {
            $query = $query->where('admin', 1);
        } elseif ($request->input('type') == 'normal') {
            $query = $query->where('admin', 0);

        }

        if ($request->input('status') == 'blocked') {
            $query = $query->where('blocked', 1);
        } elseif ($request->input('status') == 'unblocked') {
            $query = $query->where('blocked', 0);
        }

        if ($name != null) {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }


        $users = $query->get();

        return view('users.search', compact('users'));


    }


}

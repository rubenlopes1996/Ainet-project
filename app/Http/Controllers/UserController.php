<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Movements;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Associate_members;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('users.profile', array('user' => Auth::user()));
    }

    public function profiles(Request $request, User $user)
    {
        $name = $request->query('name', null);

        $query = User::query()->with(['associated', 'associated_members']);

        if ($name == null) {
            $users = $query->get();
            return view('users.showProfile', compact('users'));
        }
        if ($name != null) {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }

        $users = $query->get();

        return view('users.showProfile', compact('users'));

    }


    public function editPassword()
    {
        $user = Auth::user();

        return view('users.editPassword', [
            "user" => $user,

        ]);
    }

    public function updatePassword(Request $request)
    { //old password deve ser diferente da nova
        $user = Auth::user();
        $dados = $request->validate([
            'old_password' => 'required|min:3|max:15',
            'password' => 'required|min:3|max:15',
            'password_confirmation' => 'required|min:3|max:15'
        ]);

        if (!Hash::check($dados['old_password'], $user->password)) {

            return redirect()->route('profile.password')->withErrors(['old_password' => 'Old password not valid!']);
        }

        if ($dados['password_confirmation'] != $dados['password']) {
            return redirect()->route('profile.password')->withErrors(['password' => 'Password is diferent! Please confirme new password!']);
        }

        $user->password = Hash::make($dados['password']);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password has been changed!');


    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('users.editProfile', [
            "user" => $user,

        ]);
    }

    public function editProfileConfirm(Request $request)
    {
        $user = Auth::user();
        $dados = $request->validate([
            'name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'phone' => 'nullable|regex:/^([+]\d{2,3})?\s*\d{3}\s*\d{3}\s*\d{3}$/',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image',
        ]);

        $user->name = $dados['name'];
        $user->email = $dados['email'];
        $user->phone = $dados['phone'] ?? null;
        $file = $dados['profile_photo'] ?? null;

        if ($file != null) {

            $file_name = basename($file->store('profiles', 'public'));

            $user->update(['profile_photo' => $file_name]);
        }

        $user->save();
        return redirect()->route('profile')->with('success', 'Profile has been Edited');


    }

    //UserStory12
    public function associates(User $user)
    {
        $users = $user::findorfail(Auth::id())->associated;

        return view('users.associate', compact('users'));

    }

    //UserStory13
    public function associates_of(User $user)
    {
        $users = $user::findorfail(Auth::id())->associated_members;

        return view('users.associate_of', compact('users'));
    }


    public function addAssociate(Request $request)
    {
           if (Auth::id() != $request->get('id')) {
               if ($request->get('id') != null) {

                   $members = Associate_members::where('main_user_id', Auth::id())->get();
                   $encontrado = User::findOrFail($request->get('id'));
                   if (isset($encontrado)) {
                       $flag = 0;
                       foreach ($members as $member) {
                           if ($flag == 0) {
                               if ($member->associated_user_id != $request->get('id')) {

                                   if (Auth::id() != $request->get('id')) {
                                       $flag = 1;
                                       $associate = Associate_members::create([
                                           'main_user_id' => Auth::id(),
                                           'associated_user_id' => $encontrado->id,
                                           'created_at' => Carbon::now(),
                                       ]);
                                       $associate->save();
                                   }
                               }
                           }
                       }
                       return view('users.profile', array('user' => Auth::user()));
                   } else {
                       return abort(404);
                   }

               } else {
                   return Response::make(view('home'), 404);
               }
           } else {
               return Response::make(view('home'), 403);
           }

    }

    public function associatesPost(Request $request)
    {
        $main = Auth::user();
        $pedido =$request->get('associate_id');
        $encontrado = User::findOrFail($pedido);
        if (!is_null($encontrado)) {
            if ($pedido != $main->id) {
                $associate = new Associate([
                    'main_user_id' => $main->id,
                    'associated_user_id' => $pedido,
                    'created_at' => Carbon::now(),
                ]);
                $associate->save();
                return redirect()->route('home');
            }
            return Response::make(view('home'), 403);
        }
        return Response::make(view('dashboard'), 404);
    }


    public function removeAssociate($user_id)
    {
        if (Auth::id() != $user_id) {
            $members = Associate_members::where('associated_user_id', Auth::id());
            $encontrado = User::findOrFail($user_id);
            if (isset($encontrado)) {
                foreach ($members as $member) {
                    if ($member->main_user_id == $encontrado->id) {
                        $toDelete = Associate_members::query()->where('associated_user_id', '=', $member->associated_user_id)
                            ->where('main_user_id', '=', $member->main_user_id);
                        $toDelete->delete();
                        return redirect()->route('profiles');
                    }
                    return redirect()->route('profiles');

                }
            } else {
                abort(404);
            }
        } else {
        }


    }


}

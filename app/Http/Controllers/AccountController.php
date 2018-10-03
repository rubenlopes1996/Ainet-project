<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Movements;
use App\Rules\ValidID;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;


class AccountController extends Controller
{

    public function createAccount()
    {
        $account = new Accounts();
        return view('accounts.register', compact('account'));

    }

    public function saveAccount(Request $request)
    {
        $data = $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
            'code' => ['required', Rule::unique('accounts')->where(function ($query) {
                return $query->where('owner_id', Auth::id());
            })],
            'start_balance' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'nullable|date',

        ]);
        if (empty($data['date'])){
            $data['date'] = date("Y-m-d");
        }else{
            $data['date'] = date("Y-m-d", strtotime($data['date']));
        }

        $accounts = Accounts::create([
            'owner_id' => Auth::id(),
            'account_type_id' => $data['account_type_id'],
            'code' => $data['code'],
            'start_balance' => $data['start_balance'],
            'description' => $data['description'] ?? null,
            'date' => $data['date'],
            'current_balance' => $data['start_balance'],
            'created_at' => Carbon::now(),
        ]);


        $accounts->save();
        return redirect()->route('profile')->with('success', 'Account created with success');

    }

    public function editAccount($id)
    {
        $account = Accounts::findOrFail($id);
        return view('accounts.editAccount', compact('account'));

    }

    public function updateAccount(Request $request, $id)

    {
        $accounts = Accounts::findOrFail($id);
        $auxMovements = Movements::all()->where('account_id', '=', $accounts->id);
        $startBalanceAux = $accounts->start_balance;


        if (Auth::id() == $accounts->owner_id) {

            $data = $request->validate([
                'account_type_id' => 'required|exists:account_types,id',
                'code' => ['required', Rule::unique('accounts')->where(function ($query) {
                    return $query->where('owner_id', Auth::id());
                })], 'start_balance' => 'required|numeric',
                'description' => 'nullable|string',
                'date' => 'required|date',
            ]);

            $accounts->owner_id = Auth::id();
            $accounts->account_type_id = $data['account_type_id'];
            $accounts->code = $data['code'];
            $accounts->start_balance = $data['start_balance'];
            $accounts->description = $data['description'] ?? null;
            $accounts->date = $data['date'] ?? Carbon::now();
            $accounts->update();


            if ($startBalanceAux != $accounts->start_balance) {

                $difference = $accounts->start_balance - $startBalanceAux;
                $accounts->current_balance += $difference;
                $accounts->update();

                foreach ($auxMovements as $movement) {
                    $movement->start_balance += $difference;
                    $movement->end_balance += $difference;
                    $movement->update();
                }

            }

            return redirect()->route('profile')->with('success', 'Account has been changed!');

        }
        abort(403);

    }

    //UserStory14
    public function deleteAccount(Accounts $account)
    {
        if ($account->owner_id == Auth::id()) {
            $colecao = $account->hasMovements;
            if ($colecao->isNotEmpty() || $account->last_movement_date != null) {
                return redirect()->route('opened.accounts', $account->owner_id)->with('success', 'User has movements!');
            } else {
                $account->forceDelete();
                return redirect()->route('opened.accounts', $account->owner_id)->with('success', 'Account as been deleted!');
            }

        } else {
            abort(403);
        }

    }

    //UserStory15
    public function closeSpecificAcount(Accounts $account)
    {
        if ($account->owner_id == Auth::id()) {
            $colecao = $account->hasMovements;
            if ($colecao->isNotEmpty() || $account->last_movement_date != null) {
                return redirect()->route('opened.accounts', $account->owner_id)->with('success', 'User has movements!');
            } else {
                $account->delete();
                return redirect()->route('opened.accounts', $account->owner_id)->with('success', 'Account as been deleted!');
            }

        } else {
            abort(403);
        }
    }

    //UserStory15
    public function openSpecificAccount($id)
    {
        $account = Accounts::onlyTrashed()->findOrFail($id);

        if (is_null($account)) {
            abort(404);
        }
        if (Auth::id() == $account->owner_id) {

            $account->restore();

            return redirect()->route('opened.accounts', $account->owner_id)->with('success', 'Account as been opened!');
        }
        abort(403);
    }

    public function accounts(User $user)
    {
        if ($user->id == Auth::id()) {
            $accounts = Accounts::withTrashed()->orderBy('date', 'desc')->get();

            return view('users.accounts', compact('accounts'));
        } elseif ($user->associated()->pluck('main_user_id')->contains($user->id)) {
            $accounts = Accounts::all()->where('owner_id', '=', $user->id);
            return view('users.accountsofAssociate', compact('accounts'));
        }
        abort(403);
    }

    public function openedAccounts(User $user)
    {
        if ($user->id == Auth::id() && $user->blockek == 0) {
            $accounts = Accounts::all();
            return view('users.accountsOpened', compact('accounts'));
        }
        abort(403);
    }

    public function closedAccounts(User $user)
    {
        if ($user->id == Auth::id() && $user->blockek == 0) {
            $accounts = Accounts::onlyTrashed()->get();

            return view('users.accountsClosed', compact('accounts'));
        }
        abort(403);
    }

}

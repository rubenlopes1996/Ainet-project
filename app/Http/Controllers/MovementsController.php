<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Documents;
use App\movementCategories;
use App\Movements;
use App\Rules\validMovementId;
use App\Rules\validMovementType;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MovementsController extends Controller
{
    public function showMovements($id)
    {
        $account = Accounts::findOrFail($id);
        $user = User::findOrFail($account->owner_id);
        if ($user->associated->pluck('id')->contains(Auth::id())) {
            $movements = Movements::query()->where('account_id', '=', $id)->orderBy('date', 'desc')->get();
            return view('movements.showMovementsAssociated', compact('movements'));
        }
        if ($account->owner_id == Auth::id()) {

            $movements = Movements::query()->where('account_id', '=', $id)->orderBy('date', 'desc')->get();
            return view('movements.showMovements', compact('movements'));

        } else {
            abort(403);
        }

    }

    public function createMovement($id)
    {
        $account = Accounts::findOrFail($id);
        if ($account->owner_id == Auth::id()) {
            return view('movements.registerMovement', compact('account'));
        }
        abort(403);

    }

    public function saveMovement(Request $request, $idACCOUNT)
    {
        $account = Accounts::findOrFail($idACCOUNT);
        if ($account->owner_id == Auth::id()) {
            //Falta verificação de conta invalida
            $data = $request->validate([
                'movement_category_id' => 'required|integer|exists:movement_categories,id',
                'value' => 'required|numeric|min:0.01',
                'description' => 'nullable|string',
                'date' => 'required|date',
            ]);

            $movements = MovementCategories::findOrFail($data['movement_category_id']);
            $data['type'] = $movements->type;

            $data['start_balance'] = 0;
            abs($data['value']);
            if ($data['type'] === 'expense') {
                $data['end_balance'] = -$data['value'];
            } else if ($data['type'] === 'revenue') {
                $data['end_balance'] = +$data['value'];
            }
            if ($request->has('document_file') || $request->has('document_description')) {
                $data2 = $request->validate([
                    'document_file' => 'required|mimes:png,jpeg,pdf',
                    'document_description' => 'nullable|string',
                ]);

                $movements = Movements::create([
                    'account_id' => $idACCOUNT,
                    'movement_category_id' => $data['movement_category_id'],
                    'type' => $data['type'],
                    'value' => $data['value'],
                    'start_balance' => $data['start_balance'],
                    'end_balance' => $data['end_balance'],
                    'description' => $data['description'] ?? null,
                    'date' => $data['date'] ?? Carbon::now(),
                    'created_at' => Carbon::now(),
                ]);


                $document = Documents::create([
                    'type' => $data2['document_file']->getClientOriginalExtension(),
                    'original_name' => $data2['document_file']->getClientOriginalName(),
                    'description' => $data2['document_description'] ?? null,
                    'created_at' => Carbon::now(),
                ]);
                $data2['document_file']->storeAs('documents/' . $account->id, $movements->id . "." . $data2['document_file']->getClientOriginalExtension());
                $document->save();
                $movements->document_id = $document->id;

            } else {


                $movements = Movements::create([
                    'account_id' => $idACCOUNT,
                    'movement_category_id' => $data['movement_category_id'],
                    'type' => $data['type'],
                    'value' => $data['value'],
                    'start_balance' => $data['start_balance'],
                    'end_balance' => $data['end_balance'],
                    'description' => $data['description'] ?? null,
                    'document_id' => null,
                    'date' => $data['date'] ?? Carbon::now(),
                    'created_at' => Carbon::now(),
                ]);

            }

            /*   $startBalanceAux = $account->start_balance;
               $auxMovements = Movements::all()->where('account_id', '=', $account->id);
               if ($startBalanceAux != $account->start_balance) {

                   $difference = $account->start_balance - $startBalanceAux;
                   $account->current_balance += $difference;
                   $account->update();

                   foreach ($auxMovements as $movement) {
                       $movement->start_balance += $difference;
                       $movement->end_balance += $difference;
                       $movement->update();
                   }

               }
   */
            $movements->save();
            return redirect()->route('profile')->with('success', 'Movement created with success');
        } else {
            abort(403);
        }
    }

    public function editMovement($idMovement)
    {
        $movement = Movements::findOrFail($idMovement);
        $accountId = $movement->account_id;
        $account = Accounts::findOrFail($accountId);

        if ($account->owner_id == Auth::id()) {
            return view('movements.editMovement', compact('movement'));
        }
        abort(403);
    }

    public function updateMovement(Request $request, $idMovement)
    {
        $movement = Movements::findOrFail($idMovement);
        $accountId = $movement->account_id;
        $account = Accounts::findOrFail($accountId);

        if (Auth::id() == $account->owner_id) {
            if ($accountId == $movement->account_id) {
                $data = $request->validate([
                    'movement_category_id' => 'required|integer|exists:movement_categories,id',
                    'value' => 'required|numeric|min:0.01',
                    'description' => 'nullable|string',
                    'date' => 'required|date',
                ]);

                $categories = MovementCategories::findOrFail($data['movement_category_id']);

                $data['type'] = $categories->type;

                $data['start_balance'] = 0;

                if ($request->has('document_file') || $request->has('document_description')) {
                    $data2 = $request->validate([
                        'document_file' => 'required|mimes:png,jpeg,pdf',
                        'document_description' => 'nullable|string',
                    ]);


                    $document = Documents::create([
                        'type' => $data2['document_file']->getClientOriginalExtension(),
                        'original_name' => $data2['document_file']->getClientOriginalName(),
                        'description' => $data2['document_description'] ?? null,
                        'created_at' => Carbon::now(),
                    ]);

                    if (is_null($movement->document_id)) {
                        $data2['document_file']->storeAs('documents/' . $account->id, $movement->id . "." . $data2['document_file']->getClientOriginalExtension());
                        $document->save();
                        $movement->document_id = $document->id;
                    } else {

                        $documentDeleted = Documents::findOrFail($movement->document_id);
                        $movement->document_id = null;
                        $movement->save();
                        $documentDeleted->forceDelete();
                        Storage::disk('local')->delete('documents/' . $account->id . "/" . $movement->id . "." . $documentDeleted->type);
                        $data2['document_file']->storeAs('documents/' . $account->id, $movement->id . "." . $data2['document_file']->getClientOriginalExtension());
                        $document->save();
                        $movement->document_id = $document->id;
                    }
                }


                $movement->account_id = $accountId;
                $movement->movement_category_id = $data['movement_category_id'];
                $movement->type = $data['type'];
                $movement->value = $data['value'];
                $movement->description = $data['description'] ?? null;
                $movement->date = $data['date'];


                $movement->update();
                return redirect()->route('profile')->with('success', 'Movement created with success');
            } else {
                abort(403);
            }
        } else {
            abort(403);
        }
    }


    public
    function destroyMovement($idMovement)
    {
        $movement = Movements::findOrFail($idMovement);
        $accountId = $movement->account_id;
        $account = Accounts::findOrFail($accountId);

        if (Auth::id() == $account->owner_id) {
            $movement->forceDelete();
            if (!is_null($movement->document_id)) {
                $document = Documents::findOrFail($movement->document_id);
                $document->forceDelete();
                $movement->document_id = null;
                Storage::disk('local')->delete('documents/' . $account->id . "/" . $movement->id . "." . $document->type);

            }

            //só para retornar a vista
            $movements = Movements::query()->where('account_id', '=', $accountId)->orderBy('date', 'desc')->get();
            return view('movements.showMovements', compact('movements'))->with('sucess', "Movement deleted with sucess");

        } else {
            abort(403);
        }


    }

    public function showuploadDocument($idMovement)
    {
        $movement = Movements::findOrFail($idMovement);
        return view('movements.uploadDocument', compact('movement'));
    }

    public function uploadDocument(Request $request, $idMovement)
    {
        $movement = Movements::findOrFail($idMovement);
        $account = Accounts::findOrFail($movement->account_id);

        if ($account->owner_id == Auth::id()) {

            if ($request->has('document_file') || $request->has('document_description')) {
                $data = $request->validate([
                    'document_file' => 'required|mimes:png,jpeg,pdf',
                    'document_description' => 'nullable|string',
                ]);

                $document = Documents::create([
                    'type' => $data['document_file']->getClientOriginalExtension(),
                    'original_name' => $data['document_file']->getClientOriginalName(),
                    'description' => $data['document_description'] ?? null,
                    'created_at' => Carbon::now(),
                ]);

                if (is_null($movement->document_id)) {
                    $data['document_file']->storeAs('documents/' . $movement->account_id, $movement->id . "." . $data['document_file']->getClientOriginalExtension());
                    $document->save();
                    $movement->document_id = $document->id;
                    $movement->save();
                } else {
                    $documentDeleted = Documents::findOrFail($movement->document_id);
                    $movement->document_id = null;
                    $movement->update();
                    $documentDeleted->forceDelete();
                    Storage::disk('local')->delete('documents/' . $movement->account_id . "/" . $movement->id . "." . $documentDeleted->type);
                    $data['document_file']->storeAs('documents/' . $movement->account_id, $movement->id . "." . $data['document_file']->getClientOriginalExtension());
                    $document->save();
                    $movement->document_id = $document->id;
                    $movement->save();
                }

                $movements = Movements::query()->where('account_id', '=', $movement->account_id)->orderBy('date', 'desc')->get();
                return view('movements.showMovements', compact('movements'));
            }
        } else {
            abort(403);
        }
    }

    public
    function showDocument($idDocument)
    {
        $document = Documents::findOrFail($idDocument);
        $account = Accounts::findOrFail($document->hasMovement->account_id);
        $movement = $document->hasMovement;
        $user = User::findOrFail($account->owner_id);

        if (Auth::id() == $account->owner_id || $user->associated->pluck('id')->contains(Auth::id())) {
            if ($movement->document_id != null) {
                $path = storage_path('app/documents/' . $account->id . '/' . $movement->id . '.' . $document->type);
                return response()->file($path);
            } else {
                $movements = Movements::query()->where('account_id', '=', $movement->account_id)->orderBy('date', 'desc')->get();
                return view('movements.showMovements', compact('movements'));
            }
        } else {
            abort(403);
        }
    }

//25
    public
    function downloadDocument(Documents $document)
    {
        $movement = Movements::where('document_id',$document->id)->first();
        $account = Accounts::findOrFail($movement->account_id);
        $user = User::findOrFail($account->owner_id);

        if (Auth::id() == $account->owner_id || $user->associated->pluck('id')->contains(Auth::id())) {
            if ($movement->document_id != null) {
                $path = 'documents/' . $account->id . '/' . $movement->id . '.' . $document->type;
                return Storage::download($path, $document->original_name);
            } else {
                return view('movements.showMovements', compact('account'))->with('Movement does not have an associated document');
            }


        } else {
            abort(403);
        }
    }

//24
    public function deleteDocument($idDocument)
    {
        $document = Documents::findOrFail($idDocument);
        $movement = $document->hasMovement;
        $accountId = $movement->account_id;
        $account = Accounts::findOrFail($accountId);


        if (Auth::id() == $account->owner_id) {
            $movement->document_id = null;
            $movement->update();
            $document->forceDelete();
            Storage::disk('local')->delete('documents/' . $accountId . "/" . $movement->id . "." . $document->type);

            //só para retornar a vista
            $movements = Movements::query()->where('account_id', '=', $accountId)->orderBy('date', 'desc')->get();
            return view('movements.showMovements', compact('movements'))->with('sucess', "Movement deleted with sucess");

        } else {
            abort(403);
        }


    }

}

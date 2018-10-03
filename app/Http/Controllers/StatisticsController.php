<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\movementCategories;
use App\Movements;
use App\Statistics;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Khill\Lavacharts\Lavacharts;

class statisticsController extends Controller
{


    public function registeredUsers()
    {
        $numberOfRegisteredUsers = User::count();
        $numberOfRegisteredAccounts = Accounts::count();
        $numberOfRegisteredMovements = Movements::count();
        return view('welcome', compact('numberOfRegisteredUsers', 'numberOfRegisteredAccounts', 'numberOfRegisteredMovements'));
    }

    public function showStatistics($AccountId)
    {
        $movementsUSer = Movements::all()->where('account_id', '=', $AccountId);
        dd($movementsUSer);


        return view('users.statisticsInformation', compact('account'));
    }


    public function showStatAll($id)

    {
        $user = User::FindOrFail($id);
        if ($user->id == Auth::id()) {
            $accounts = Accounts::all();
            $movements = Movements::all();
            $lava = new Lavacharts; // See note below for Laravel
            $aux = ($accounts->pluck('current_balance'));
            $aux2 = ($accounts->pluck('start_balance'));
            $aux3 = ($movements->pluck('value'));

            $totalBalance = 0;
            $starBalance = array();
            $values = array();

            $percentagem = array();
            for ($i = 0; $i < $accounts->count(); $i++) {
                $totalBalance += $aux->get($i);
                $starBalance = array_add($starBalance, $i, $aux2->get($i));
                $percentagem = array_add($percentagem, $i, $aux->get($i));
            }
            for ($h = 0; $h < count($movements); $h++) {
                $values = array_add($values, $h, $aux3->get($h));
            }
            $idMovementCategories = $movements->pluck('movement_category_id')->getIterator();
            $idAccounts = $accounts->pluck('id')->getIterator();
            $percentagem_final = array();
            for ($j = 0; $j < count($percentagem); $j++) {
                $percentagem_final = array_add($percentagem_final, $j, $percentagem[$j]);
                $percentagem_final[$j] = $percentagem_final[$j] / $totalBalance * 100;
            }
            $finances = $lava->DataTable();
            $finances->addNumberColumn('Account')
                ->addNumberColumn('Current Balance')->addNumberColumn('Star Balance')->addNumberColumn('Average Balance');
            $percGraph = $lava->DataTable();

            $percGraph->addNumberColumn('Percentage')->addNumberColumn('Average Percentage');
            // ->addNumberColumn('Total Balance');
            $a = 0;
            foreach ($idAccounts as $value) {
//ESTE GRAFICO NO 2 PARAMETRO E COLUNA E NO 3 E LINHA(MEDIA)


                $finances->addRow([$value, $percentagem[$a], $starBalance[$a], $totalBalance / count($idAccounts)]);


                $lava->ComboChart('Finances', $finances, [
                    'title' => 'Balance of Accounts',
                    'titleTextStyle' => [
                        'color' => 'rgb(123, 65, 89)',
                        'fontSize' => 16
                    ],
                    'legend' => [
                        'position' => 'in'
                    ],
                    'seriesType' => 'bars',
                    'series' => [
                        2 => ['type' => 'line']
                    ]
                ]);


                $percGraph->addRow([$value, $percentagem_final[$a]]);
                $a += 1;

                $lava->ComboChart('Percentage', $percGraph, [
                    'title' => 'Percentage of total balance by accounts',
                    'titleTextStyle' => [
                        'color' => 'rgb(123, 65, 89)',
                        'fontSize' => 16
                    ],
                    'legend' => [
                        'position' => 'in'
                    ],
                    'seriesType' => 'bars',
                    'series' => [
                        2 => ['type' => 'line']
                    ]
                ]);
            }

            $p = 0;
            $food = $clothes = $service = $electricity = $phone = $fuel = $mortage_payment = $salary = $bonus = $royaltis = $interests = $gifts = $dividends = $product_sale = 0;
            foreach ($values as $valueAUX) {


                switch ($idMovementCategories[$p]) {
                    case 1:
                        $food += $valueAUX;
                    case 2:
                        $clothes += $valueAUX;
                    case 3:
                        $service += $valueAUX;
                    case 4:
                        $electricity += $valueAUX;
                    case 5:
                        $phone += $valueAUX;
                    case 6:
                        $fuel += $valueAUX;
                    case 7:
                        $mortage_payment += $valueAUX;
                    case 8:
                        $salary += $valueAUX;
                    case 9:
                        $bonus += $valueAUX;
                    case 10:
                        $royaltis += $valueAUX;
                    case 11:
                        $interests += $valueAUX;
                    case 12:
                        $gifts += $valueAUX;
                    case 13:
                        $dividends += $valueAUX;
                    case 14:
                        $product_sale += $valueAUX;
                }
                $p += 1;
            }
            $movementValueGraph = $lava->DataTable();
            $objAux = MovementCategories::all();
            $objAux = $objAux->pluck('name');

            $movementValueGraph->addStringColumn('Categories')
                ->addNumberColumn('Percent')
                ->addRow([$objAux[0], $food])
                ->addRow([$objAux[1], $clothes])
                ->addRow([$objAux[2], $service])
                ->addRow([$objAux[3], $electricity])
                ->addRow([$objAux[4], $phone])
                ->addRow([$objAux[5], $fuel])
                ->addRow([$objAux[6], $mortage_payment])
                ->addRow([$objAux[7], $salary])
                ->addRow([$objAux[8], $bonus])
                ->addRow([$objAux[9], $royaltis])
                ->addRow([$objAux[10], $interests])
                ->addRow([$objAux[11], $gifts])
                ->addRow([$objAux[12], $dividends])
                ->addRow([$objAux[13], $product_sale]);


            $lava->PieChart('MovementsGraph', $movementValueGraph, [
                'title' => 'Percentage per Categories',
                'is3D' => true,


            ]);

            return view('users.statisticsInformation', compact('totalBalance', 'percentagem_final', 'lava', 'finances', 'percGraph', 'idAccounts', 'idMovementCategories', 'values', 'movementValueGraph'));
        }
        abort(403);
    }



    public function ShowTimeFrame(){

        return view('users.statisticsTimeFrame');

    }




}

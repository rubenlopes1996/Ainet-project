@extends('master')

@section('title', 'Statistics Information')

@section('content')
    <form method="get" action="{{route('showStatisticsTimeFrame')}}">
        <button type="submit" class="btn btn-primary">Statistics By Time Frame</button>
    </form>



    <div id="finances-div"></div>

    <?= $lava->render('ComboChart', 'Finances', 'finances-div') ?>
    <div id="percentagem-div"></div>

    <?= $lava->render('ComboChart', 'Percentage', 'percentagem-div') ?>

    <div id="chart-div"></div>
    // With Lava class alias
    <?=$lava->render('PieChart', 'MovementsGraph', 'chart-div') ?>


    <h2>TotalExpenses : {{$totalBalance}} Ä</h2>
    <table class="table table-striped" border="1">
        <thead>
        <tr>
            <th>Percentage of balance Accounts</th>
            <th>Account</th>
        </tr>
        </thead>

        @foreach($percentagem_final as $percentagem )

            <tbody>

            <td>{{round($percentagem,3)}} %</td>


            @endforeach

            @foreach($idAccounts as $account)
                <th>
                <td>{{$account}}</td>
                </th>


            </tbody>
        @endforeach


    </table>

    <table class="table table-striped" border="1">
        <thead>
        <tr>
            <th>Category</th>
            <th>Value</th>
        </tr>
        </thead>

        @foreach($idMovementCategories as $category )

            <tbody>
            <td>{{$category/*->movementToSTR()*/}} </td>


            @endforeach

            @foreach($values as $value)
                <th>
                <td>{{round($value,2)}}</td>
                </th>


            </tbody>
        @endforeach


    </table>

@endsection

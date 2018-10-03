<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Personal Finances Application</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .flex-center {
            align-items: flex-start;
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .content {
            font-size: 20px;
            margin-left: 5%;

        }

    </style>
</head>
<body>
@if (Route::has('login'))
    <div class="top-right links">
        @auth
            <a href="{{ url('/home') }}">Home</a>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
@endif
<div class="flex-center position-ref full-height">
    <div class="title">
        Personal Finances Application
    </div>

</div>


<div class="content">
    <div>
        Total of registered users:
        {{$numberOfRegisteredUsers}}
    </div>

    <div>
        Total number of active accounts:
        {{$numberOfRegisteredAccounts}}

    </div>

    <div>
        Total movements registered on the plataform:
        {{$numberOfRegisteredMovements}}

    </div>
    <div>
        <p id="date"></p>
        <script>
            document.getElementById("date").innerHTML = Date();
        </script>
    </div>
</div>
</body>

</html>

<!doctype html>
<html>
<head>
    @include('includes.head', ['css' => false])
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            /*color: #B0BEC5;*/
            background-color: #22A7F0;
            display: table;
            font-weight: 100;
            font-family: 'Lato', sans-serif;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content_err {
            text-align: center;
            display: inline-block;
        }

        .title_err {
            font-size: 72px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body class="flat-blue login-page register-page">

    @yield('content')

</body>
</html>

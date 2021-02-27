<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('admin//images/icons/hi.ico')}}"/>
    <link rel="stylesheet" href="{{asset('admin/bootstrap/css/bootstrap.min.css')}}">
    <title>404</title>
</head>
<body class="nav-md">
    <style>
        body {
            color: #73879C;
            background: #2A3F54;
            font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.471;
        }

        .container {
            width: 100%;
            padding: 0;
        }

        .col-middle {
            margin-top: 5%;
        }

        .error-number {
            font-size: 90px;
            line-height: 90px;
            margin: 20px 0;
        }

        h2 {
            font-size: 18px;
            font-weight: 400;
        }

        p {
            margin: 0 0 10px;
        }

        .mid_center {
            width: 370px;
            margin: 0 auto;
            text-align: center;
            padding: 10px 20px;
        }

        .btn-round {
            border-radius: 30px;
        }
    </style>

    <div class="container body">
        <div class="main_container">
            <!-- page content -->
            <div class="col-md-12">
                <div class="col-middle">
                    <div class="text-center text-center">
                        <h1 class="error-number">404</h1>
                        <h2>Sorry but we couldn't find this page</h2>
                        <p>This page you are looking for does not exist.
                        </p>
                        <div class="mid_center">
                            <a href="/">
                                <button class="btn btn-round btn-light" type="button">Back!</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
</body>
</html>
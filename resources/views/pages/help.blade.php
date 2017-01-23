<!DOCTYPE html>
<html>
    <head>
        <title>TAGiT</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">TAGiT API Help</div>
				<p><strong>{{$flag}}</strong>{{$place}}</p>
                @if($flag == true)
                    In if!!
                @else
                    In Else!!
                @endif
            </div>
        </div>
    </body>
</html>

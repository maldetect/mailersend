<!DOCTYPE html>
    <html>

	<head>
        <meta charset="utf-8">
	    <meta name="theme-color" content="#317EFB"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Mailer Send</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href=" {{ mix('css/app.css') }}" rel="stylesheet">



    </head>
    <body>
        <div id="app" >
            <app ></app>
        </div>





        <script src="{{ mix('js/bootstrap.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>

    </body>
    </html>

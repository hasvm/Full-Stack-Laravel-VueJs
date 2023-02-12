<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>MZT test assignment</title>

        <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap" rel="stylesheet">
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      
      <script src="assets/js/plugins/jQuery/jquery-3.6.3.min.js" type="text/javascript"></script>

   </head>
   <body>
      <div id="app">
         <app></app>
      </div>

      <script src="{{ mix('/js/app.js') }}"></script>
   </body>

    <style>
      body {
         font-family: 'Roboto', sans-serif;
       }
   </style>
</html>
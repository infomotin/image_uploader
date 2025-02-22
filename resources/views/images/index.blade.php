<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{-- link tailwind css  --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Image Uploading with Laravel + Vue JS</title>
</head>
<body>
    <div class="max-w-lg mx-auto mt-24">
        <h1 class="text-4xl font-bold text-center">Image Uploading</h1>
        <div id="app">

        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
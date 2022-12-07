<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>

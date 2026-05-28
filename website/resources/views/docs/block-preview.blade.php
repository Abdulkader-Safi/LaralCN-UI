<!DOCTYPE html>
<html lang="en" x-data="{ dark: false }" :class="{ 'dark': dark }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — LaralCN-UI Blocks</title>
    <meta name="description"
        content="{{ $title }} block built from LaralCN-UI components.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
</head>

<body class="bg-background text-foreground antialiased">
    {!! Illuminate\Support\Facades\Blade::render($source) !!}
</body>

</html>

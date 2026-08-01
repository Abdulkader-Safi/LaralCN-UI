<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — LaralCN-UI Blocks</title>
    <meta name="description"
        content="{{ $title }} block built from LaralCN-UI components.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background text-foreground antialiased">
    {!! Illuminate\Support\Facades\Blade::render($source) !!}
</body>

</html>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}"
        }
    </script>
</head>
<body>
    <div id="app">

    </div>
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/dashboard.js') }}"></script>
</body>
</html>

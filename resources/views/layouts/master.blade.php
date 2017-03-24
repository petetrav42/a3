<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Assignment 3')</title>

    <meta charset='utf-8'>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>
    <link href="/css/style.css" type='text/css' rel='stylesheet'>
    @stack('head')
</head>
<body>
    <div id='mainContainer'>
        <header>

        </header>
        <nav>
            @yield('nav')
        </nav>
        <section>
            @yield('content')
        </section>
        <footer>
            &copy; {{ date('Y') }} | Bonzella.com
        </footer>
        @stack('body')
    </div>
</body>
</html>
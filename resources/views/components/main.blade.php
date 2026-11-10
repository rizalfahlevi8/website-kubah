<!DOCTYPE html>
<html lang="en">

@include('components.head')

<body>
    @include('components.header')

    @include('components.sidebar')

    <main id="main" class="main">
        @yield('content')
    </main>

    @include('components.js')
    
</body>

</html>

@include('Admin.Layouts.partials.head.head-links')
@include('Admin.Layouts.partials.head.head-meta')

<body>
    @include('Admin.Layouts.partials.header')
    @include('Admin.Layouts.partials.topbar-second')


    @include('Admin.Layouts.partials.sidebar-collapse')
    <div id="content" class="position-relative h-100">
        @yield('content')
    </div>
</body>



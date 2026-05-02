

<meta name="msapplication-TileColor" content="#ffffff" />
<meta name="msapplication-TileImage" content="{{ asset('Admin/assets/images/favicon/ms-icon-144x144.png') }}" />
<meta name="theme-color" content="#ffffff" />
<!-- Color modes -->
<script src="{{ asset('Admin/assets/js/vendors/color-modes.js') }}"></script>
<script>
  if (localStorage.getItem('sidebarExpanded') === 'false') {
    document.documentElement.classList.add('collapsed');
    document.documentElement.classList.remove('expanded');
  } else {
    document.documentElement.classList.remove('collapsed');
    document.documentElement.classList.add('expanded');
  }
</script>
<!-- Libs CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" />
<link rel="stylesheet" href="{{ asset('Admin/assets/scss/theme/utilities/_simplebar.scss') }}" />
<link rel="stylesheet" href="{{ asset('Admin/assets/scss/theme/utilities/_simplebar.scss') }}" />

<!-- Theme CSS -->
<!-- build:css @@webRoot/assets/css/theme.min.css -->
<link rel="stylesheet" href="{{ asset('Admin/assets/css/theme.css') }}" />
<!-- endbuild -->

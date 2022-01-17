<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Management @yield('title')</title>
  <link rel="icon" href="{{ asset('/images/logo.png') }}" type="image/x-icon" />

  <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
  .select2-selection__rendered {
    line-height: 34px !important;
  }
  .select2-container .select2-selection--single {
      height: 35px !important;
      padding-top:3px;
  }
  .select2-selection__arrow {
      height: 34px !important;
  }
  .select2-container--default .select2-dropdown .select2-search__field:focus, .select2-container--default .select2-search--inline .select2-search__field:focus{
    border:none;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice__display{
    padding-left:14px;
    padding-right:14px;
    color:black;
  }
  </style>
  @yield('styles')


</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">

	@include('layouts.topnav')

	@include('layouts.sidenav')
		<div class="content-wrapper">
			<div class="content">
				@includeWhen(session()->has('success'), 'components.alert-session', [
					'alert' => 'success', 'icon' => 'fas fa-check', 'session_name' => 'success'
				])
				@includeWhen(session()->has('error'), 'components.alert-session', [
					'alert' => 'danger', 'icon' => 'fas fa-exclamation','session_name' => 'error'
				])
				@includeWhen(session()->has('message'), 'components.alert-session', [
					'alert' => 'info', 'icon' => 'fas fa-info', 'session_name' => 'message'
				])
				@include('components.breadcrumbs')
				@yield('content')
			</div>
		</div>
	@include('layouts.footer')

  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
	   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  </script>
  @yield('scripts')


</body>
</html>

<!DOCTYPE html>
<html lang="en" class="logged-out {{ config('visibility.page_rendering') }}">

<!--html header-->
@include('layout.header')
<!--html header-->

<body class="{{ $page['page'] ?? '' }}">
    <!--preloader-->
    @if(config('visibility.page_rendering') == '' || config('visibility.page_rendering') != 'print-page')
    <div class="preloader">
        <div class="loader">
            <div class="loader-loading"></div>
        </div>
    </div>
    @endif
    <!--preloader-->

    <!--main content-->
    <div id="main-wrapper">
        @yield('content')
    </div>

    <!--common modals-->
    @include('modals.actions-modal-wrapper')
    @include('modals.common-modal-wrapper')
</body>

@include('layout.footerjs')
<!--js automations-->
@include('layout.automationjs')
<!--[note: no sanitizing required] for this trusted content, which is added by the admin-->
{!! config('system.settings_theme_body') !!}

<!--[PRINTING]-->
@if(config('visibility.page_rendering') == 'print-page')
<script src="{{ asset('public/js/dynamic/print.js') }}?v={{ config('system.versioning') }}"></script>
@endif
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
</html>
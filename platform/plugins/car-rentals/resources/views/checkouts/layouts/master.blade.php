<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <title> @yield('title', __('Checkout')) </title>

    @if (theme_option('favicon'))
        <link
            href="{{ RvMedia::getImageUrl(theme_option('favicon')) }}"
            rel="shortcut icon"
        >
    @endif

    {!! Theme::typography()->renderCssVariables() !!}

    <style>
        :root {
            --primary-color: {{ $primaryColor = theme_option('primary_color', '#58b3f0') }};
            --primary-color-rgb: {{ implode(',', BaseHelper::hexToRgb($primaryColor)) }};
        }
    </style>

    {!! Html::style('vendor/core/core/base/libraries/font-awesome/css/fontawesome.min.css') !!}
    {!! Html::style('vendor/core/core/base/libraries/ckeditor/content-styles.css?v=3.8.0') !!}
    {!! Html::style('vendor/core/plugins/car-rentals/css/front-theme.css?v=3.8.0') !!}

    @if (BaseHelper::isRtlEnabled())
        {!! Html::style('vendor/core/plugins/car-rentals/css/front-theme-rtl.css?v=3.8.0') !!}
    @endif

    {!! Html::style('vendor/core/core/base/libraries/toastr/toastr.min.css') !!}

    {!! Html::script('vendor/core/plugins/car-rentals/js/checkout.js?v=3.8.0') !!}

    {!! apply_filters('car_rentals_checkout_header', null) !!}

    @stack('header')
</head>

@php
    Theme::addBodyAttributes([
        'class' => 'checkout-page',
    ]);
@endphp

<body{!! Theme::bodyAttributes() !!}>
{!! apply_filters('car_rentals_checkout_body', null) !!}
<div class="container my-0 my-md-3 my-lg-5 checkout-content-wrap">
    @yield('content')
</div>

@stack('footer')

{!! Html::script('vendor/core/core/base/libraries/toastr/toastr.min.js') !!}

<script type="text/javascript">
    window.messages = {
        error_header: '{{ __('Error') }}',
        success_header: '{{ __('Success') }}',
    }
</script>

    @if (session()->has('success_msg') || session()->has('error_msg') || ! $errors->isEmpty())
        <script type="text/javascript">
            $(document).ready(function() {
                @if (session()->has('success_msg') && session('success_msg'))
                    MainCheckout.showNotice('success', '{{ session('success_msg') }}');
                @endif
                @if (session()->has('error_msg'))
                    MainCheckout.showNotice('error', '{{ session('error_msg') }}');
                @endif
                @if (isset($errors) && $errors->count())
                    MainCheckout.showNotice('error', '{{ $errors->first() }}');
                @endif
            });
        </script>
    @endif

{!! apply_filters('car_rentals_checkout_footer', null) !!}

</body>
</html>

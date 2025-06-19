<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {!!site_title!!}</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{url('assets/backend')}}/css/pages/login/classic/login-4.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/backend')}}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/backend')}}/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/backend')}}/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/backend')}}/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/backend')}}/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/backend')}}/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{!!site_favicon!!}" />
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div class="d-flex flex-column flex-root">
        <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
            <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
                style="background-image: url({{url('assets/backend')}}/media/bg/bg-2.jpg);">
                <div class="login-form text-center p-7 position-relative overflow-hidden">
                    <div class="d-flex flex-center mb-15">
                        <h1 style="color: #FFF;width: 100%;padding: 5px;border-radius: 5px"><img src="{{site_header_logo}}" alt="" class="img-fluid" width="150"></h1>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };
    </script>
    <script src="{{url('assets/backend')}}/plugins/global/plugins.bundle.js"></script>
    <script src="{{url('assets/backend')}}/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="{{url('assets/backend')}}/js/scripts.bundle.js"></script>
    <script src="{{url('assets/backend')}}/js/pages/features/miscellaneous/toastr.js"></script>
    <script src="{{url('assets/backend')}}/js/custom.js"></script>
    <script>
    $(function() {

        @if(Session::get('info'))
        show_toastr("info", "{{ Session::get('info') }}", "");
        <?php Session::forget('info'); ?>
        @endif

        @if(Session::get('warning'))
        show_toastr("warning", "{{ Session::get('warning') }}", "");
        <?php Session::forget('warning'); ?>
        @endif

        @if(Session::get('success'))
        show_toastr("success", "{{ Session::get('success') }}", "");
        <?php Session::forget('success'); ?>
        @endif

        @if(Session::get('error'))
        show_toastr("error", "{{ Session::get('error') }}", "");
        <?php Session::forget('error'); ?>
        @endif

        <?php if ($errors->any()) { ?>
        show_toastr("error", "{{$errors-> first()}}", "");
        <?php } ?>

    });
    </script>
</body>

</html>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0"
        />
        <!-- PWA  -->
        <link rel="icon" href="{{URL::to('img/mcom.png')}}" sizes="192x192" />
        <meta name="theme-color" content="#6777ef" />
        <link rel="apple-touch-icon" href="{{ asset('logo.png') }}" />
        <link rel="manifest" href="{{ asset('/manifest.json') }}" />
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ mix('/js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
    <!-- <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    console.log(
                        "Service worker registration succeeded:",
                        registration
                    );
                },
                (error) => {
                    console.error(
                        `Service worker registration failed: ${error}`
                    );
                }
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script> -->
</html>

<!doctype html>
<html lang="en" class="minimal-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Task Management System</title>

    <link rel="icon" href="{{ asset('assets/icons/favicon.ico') }}" type="image/icon" />

    <!------- Bootstrap CSS ------->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/icons.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/datepicker/css/daterangepicker.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <!---- Google Fonts ---->

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">

    <!---- loader ---->

    <style>
        #myDivboxes {
            display: none;
        }

        #myDivboxes2 {
            display: none;
        }
    </style>
    @stack('style')

</head>

<body>

    <!----- Start Wrapper ------>
    <div class="container">
        @yield('content')
    </div>
    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datepicker/js/datepicker-latest_moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datepicker/js/daterangepicker.min.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>

    <script>
        $(function() {
            var currentDate = moment().format('MM/DD/YYYY');
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                startDate: currentDate, // Set the default start date
                endDate: currentDate
            }, function(start, end, label) {
                // Ensure that the start and end are in the desired format (e.g., 'YYYY-MM-DD')
                $.ajax({
                    url: "{{ route('task.index') }}",
                    method: 'GET',
                    data: {
                        start: start.format('YYYY-MM-DD'), // Format the start date
                        end: end.format('YYYY-MM-DD') // Format the end date
                    },
                    success: function(response) {
                        $('#taskResponse').html(response);
                    },
                    error: function(xhr, status, error) {
                        $('#taskResponse').text('An error occurred: ' + error);
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>


    @stack('script')
</body>

</html>

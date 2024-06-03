<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Room Chat</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @yield('head')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @yield('main')
    @if (session('message'))
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif
    <script>
        $('#sendMes').on('submit', function(e) {
            e.preventDefault();
            var formData = $("#sendMes").serialize();
            var mess = $('#message').val();
            $('#sendMes').trigger('reset');
            if (mess) {
                $('#message').css('border-color', '');
                $('.direct-chat-messages').append(`
                    <div class="direct-chat-msg right">
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-right">{{ session('name') }}</span>
                            <span class="direct-chat-timestamp float-left"></span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        
                        <img class="direct-chat-img" src="http://127.0.0.1:8000/img/avatar4.png" alt="Message User Image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            ${$('<div>').text(mess).html()}
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                `);
            } else {
                $('#message').css('border-color', 'red');
            }
            $.ajax({
                url: "{{ route('send-mes') }}",
                type: "POST",
                data: formData,
                success: function(res) {},
                error: function(err) {
                    console.log(err.responseJSON.message);
                }
            });
        });
        $('#upinn').on('click', function() {
            $('#file').trigger('click');
        })

        {!! Vite::content('resources/js/app.js') !!}
    </script>


    @yield('script')
</body>

</html>

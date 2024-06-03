@extends('layout.app')
@section('head')
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('css/OverlayScrollbars.min.css') }}">
@endsection
@section('main')
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        {{-- <a href="/" class="brand-link">
                <img src="{{ url('img/avatar.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a> --}}

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ url('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="/" class="d-block">{{ auth()->user()->name }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @foreach ($users as $user)
                        @if ($user->id != auth()->user()->id)
                        <li class="nav-item">
                            <a href="{{ route( 'chat', $user->id) }}" data-id="{{ $user->id }}" class="nav-link user">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    {{ $user->name }}
                                    <span class="right badge badge-success">.</span>
                                </p>
                            </a>
                        </li>
                        @endif
                    @endforeach
                    <li class="nav-header">Offline</li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @if ($page == 'onetoone')
    
    <div class="content-wrapper">
        <!-- Direct Chat -->
        <h4 class="mt-4 mb-2">DM</h4>
        {{-- <div class="row"> --}}
        <div class="col-md-9">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="card card-primary card-outline direct-chat direct-chat-primary">
                <div class="card-header">
                    <h3 class="card-title">Chat Room</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages" style="height: 500px;">
                        
                    </div>
                    <!--/.direct-chat-messages-->

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <form method="post" id="sendMes">
                        <div class="input-group">
                            @csrf
                            <input type="hidden" name="sender" id="sender" value="" />
                            <input type="hidden" name="channel" id="chn" value="" />
                            <input type="text" name="message" placeholder="Type Message ..." class="form-control col-10"
                                id="message">
                            <div class="col-1" id="upinn" style="cursor: pointer;"> <i class="fa fa-paperclip"
                                    aria-hidden="true"></i>
                            </div>
                            <input type="file" name="file" id="file" style="display: none" />
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
                <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->
        </div>
        <!-- /.col -->


    </div>
    @endif
</div>

@endsection
@section('script')
    <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('js/adminlte.min.js') }}"></script>
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

        // $('.user').on('click', function() {
        //     $('.overlay.dark').css('display', '');
        //     $('.content-wrapper').css('display', 'flex');
        //     channel = "{{ auth()->user()->id }}_" + $(this).attr('data-id');
        //     $('#sender').val($(this).attr('data-id'));
        //     $('#chn').val(channel);
        //     console.log(channel);
            
        //     $.ajax({
        //         url: "{{ route('getfullchet') }}",
        //         type: "POST",
        //         data: {
        //             'u_id': $(this).attr('data-id'),
        //         },
        //         success: function(res) {
        //             ress = $.parseJSON(res);
        //             console.log(ress);
        //             $('.overlay.dark').css('display', 'none');
        //             $('.direct-chat-messages').empty();
        //             if(ress.length > 0){
        //             ress.forEach(function(res) {
        //                 if (res.m_from == "{{ auth()->user()->id }}") {
        //                     $('.direct-chat-messages').append(`
        //                         <div class="direct-chat-msg right">
        //                             <div class="direct-chat-infos clearfix">
        //                                 <span class="direct-chat-name float-right">You</span>
        //                                 <span class="direct-chat-timestamp float-left">${res.create_at}</span>
        //                             </div>
        //                             <!-- /.direct-chat-infos -->
        //                             <img class="direct-chat-img" src="{{ url('/img/avatar4.png') }}" alt="Message User Image">
        //                             <!-- /.direct-chat-img -->
        //                             <div class="direct-chat-text">
        //                                 ${res.message}
        //                             </div>
        //                             <!-- /.direct-chat-text -->
        //                         </div>
        //                     `);
        //                 } else {
        //                     $('.direct-chat-messages').append(`
        //                         <!-- Message. Default to the left -->
        //                         <div class="direct-chat-msg">
        //                             <div class="direct-chat-infos clearfix">
        //                                 <span class="direct-chat-name float-left">${res.receiver.name}</span>
        //                                 <span class="direct-chat-timestamp float-right">${(res.created_at)?res.created_at:''}</span>
        //                             </div>
        //                             <!-- /.direct-chat-infos -->
        //                             <img class="direct-chat-img" src="{{ url('img/avatar5.png') }}" alt="Message User Image">
        //                             <!-- /.direct-chat-img -->
        //                             <div class="direct-chat-text">
        //                                 ${res.message}
        //                             </div>
        //                             <!-- /.direct-chat-text -->
        //                         </div>
        //                         <!-- /.direct-chat-msg left -->
        //                     `);
        //                 }
        //             });
        //         }
        //         },
        //         error: function(err) {
        //             console.log(err);
        //         }
        //     });
        // });


        @if ($page == 'onetoone')
    // Echo.channel(`no-chn`)
    Echo.channel(channel)
        .listen('WebappfixTest', (e) => {
            alert(e.data);
            console.log(e);
            if (e.from != "{{ auth()->user()->id; }}") {
                $('.direct-chat-messages').append(`
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">${e.to_name}</span>
                        <span class="direct-chat-timestamp float-right">at</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    {{-- <img class="direct-chat-img" src="{{url('img/user1-128x128.jpg')}}" --}}
                    <img class="direct-chat-img" src="{{ url('img/avatar5.png') }}"
                        alt="Message User Image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        ${$('<div>').text(e.data).html()}
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
            `);
                $('.direct-chat-messages').scrollTop($('.direct-chat-messages').height());
            }
        });
        @endif
    
    </script>
   
@endsection

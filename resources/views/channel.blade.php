<script type="text/javascript">
    // if(channel != null){
    Echo.channel(`no-chn`)
        .listen('WebappfixTest', (e) => {
            // alert(e.data);
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
    // }
</script>
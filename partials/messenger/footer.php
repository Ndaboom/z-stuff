<script src="assets/messenger/js/jquery-3.6.0.min.js"></script>
<script src="assets/messenger/js/bootstrap.bundle.min.js"></script>
<script src="assets/messenger/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/messenger/plugins/swiper/swiper.min.js"></script>
<script src="assets/messenger/plugins/fancybox/jquery.fancybox.min.js"></script>
<script src="assets/messenger/js/clipboard.min.js"></script>
<script src="assets/messenger/js/script.js"></script>

<script type="text/javascript">
    new ClipboardJS('.copy_msg');
    var to_user_id = <?= $_GET['i'] ?>;
    var username = '';
    var from_user_id = '';
    var image_path = '';
    var bio = '';
    var phone = '';
    var msg_content = '';
    var last_seen = '';
    var c_i = '';

    var limit = 5;
    var start = 0;
    var limit2 = 10;
    var action = 'inactive';
    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', '../../sounds/accomplished.mp3');

    setInterval(function() {
        load_data(limit, start);
        fetch_online_user();
    }, 15000); // 15 seconds

    <?php if (isset($_GET['i'])) : ?>

        init_messenger();

        function init_messenger() {
            var url = '/ajax/v2/messenger/v2/fetch_chat.php';
            var to_user_id = <?= $_GET['i'] ?>;
            var username = "<?= $_GET['n'] ?>";
            var from_user_id = <?= $_SESSION['user_id'] ?>;
            var image_path = "<?= $_GET['image_path'] ?>";
            limit = 5,
                start = 0;
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    to_user_id: to_user_id,
                    from_user_id: from_user_id,
                    start: start,
                    limit: limit
                },
                cache: false,
                beforeSend: function() {
                    $("#username").html(username);
                    $('#msg_content').attr('placeholder', 'Your message to ' + username);
                    $('.send-btn').attr('data-uid', to_user_id);
                    $('.send-btn').attr('data-username', username);
                    document.querySelector('#user_profile').setAttribute('src', image_path);
                },
                success: function(data) {
                    $("#chat_history").html(data);
                    init_video_call_box();
                }
            });
        }

    <?php endif; ?>

    function fetch_chat_history(url, to_user_id, username, from_user_id, image_path) {
        $.ajax({
            url: url,
            method: "POST",
            data: {
                to_user_id: to_user_id,
                from_user_id: from_user_id,
                start: start,
                limit: limit,
                c_i: c_i
            },
            cache: false,
            beforeSend: function() {
                $("#username").html(username);
                $('#msg_content').attr('placeholder', 'Your message to ' + username);
                $('.send-btn').attr('data-uid', to_user_id);
                $('.send-btn').attr('data-username', username);
                document.querySelector('#user_profile').setAttribute('src', image_path);
            },
            success: function(data) {
                $("#chat_history").html(data);
            }
        });
    }

    function load_data(limit, start) {
        $.ajax({
            url: "/ajax/v2/messenger/v2/fetch_users.php",
            method: "POST",
            data: {
                limit: limit,
                start: start
            },
            cache: false,
            beforeSend: function() {
                $("#spinner1").show();
            },
            success: function(data) {
                $('#users_list').html(data);
                if (data == '') {
                    action = 'active';
                } else {
                    action = 'inactive';
                }
            }
        })
    }

    if (action == 'inactive') {
        action = 'active';
        load_data(limit, start);
    }

    $(document).on('click', '.open-chat', function(e) {
        e.preventDefault();
        var url = '/ajax/v2/messenger/v2/fetch_chat.php';
        to_user_id = $(this).data('to_user_id');
        username = $(this).data('username');
        from_user_id = $(this).data('from_user_id');
        image_path = $(this).data('image_path');
        bio = $(this).data('bio');
        phone = $(this).data('userphone');
        limit = 5, start = 0;
        c_i = $(this).data('c_i');

        $.ajax({
            url: url,
            method: "POST",
            data: {
                to_user_id: to_user_id,
                from_user_id: from_user_id,
                start: start,
                limit: limit,
                c_i: c_i
            },
            cache: false,
            beforeSend: function() {
                $("#username").html(username);
                $('#msg_content').attr('placeholder', 'Your message to ' + username);
                $('.send-btn').attr('data-uid', to_user_id);
                $('.send-btn').attr('data-username', username);
                $('.send-btn').attr('data-to_user_id', to_user_id);
                $('.send-btn').attr('data-from_user_id', from_user_id);
                $('.send-btn').attr('data-image_path', image_path);
                $('.send-btn').attr('data-c_i', c_i);
                document.querySelector('#user_profile').setAttribute('src', image_path);
                document.querySelector('#current_userprofifle').setAttribute('src', image_path);
                $("#current_username").html(username);
                $("#about").html("<p>" + bio + "</p>");
                $("#userphone").html(phone);
            },
            success: function(data) {
                $("#chat_history").html(data);
                init_video_call_box();
                gotoBottom("slimscroll_box");
            }
        });
    });

    function gotoBottom(id) {
        var element = document.getElementById(id);
        element.scrollTop = element.scrollHeight - element.clientHeight;
    }

    var url = 'ajax/search.php';
    $(document).on('keyup', '.chat_form', function() {
        msg_content = $(this).val();
    });

    $(document).on('click', '.send-btn', function(e) {
        e.preventDefault();

        var uid = $(this).data('uid');
        var username = $(this).data('username');
        var url = '/ajax/v2/messenger/v2/fetch_chat.php';
        to_user_id = $(this).data('to_user_id');
        username = $(this).data('username');
        from_user_id = $(this).data('from_user_id');
        image_path = $(this).data('image_path');

        if (msg_content.length > 0) {
            $.ajax({
                url: "/ajax/insert_chat.php",
                method: "POST",
                data: {
                    to_user_id: uid,
                    chat_message: msg_content,
                    c_i: c_i
                },
                beforeSend: function() {
                    $('#msg_content').val('');
                    audioElement.play();
                },
                success: function(data) {
                    fetch_chat_history(url, to_user_id, username, from_user_id, image_path)
                }
            })
        }
    });

    $('#slimscroll_box').scroll(function() {
        var pos = $('#slimscroll_box').scrollTop();
        var url = '/ajax/v2/messenger/v2/fetch_chat.php';
        limit + 5;
        if (pos == 0) {
            fetch_chat_history(url, to_user_id, username, from_user_id, image_path);
        }
    });

    $(document).on('click', '.delete_msg', function(e) {
        e.preventDefault();

        var url = '/ajax/v2/messenger/v2/delete_message.php';
        var msg_id = $(this).data('msg_id');
        var msg_owner = $(this).data('msg_owner');

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                msg_id: msg_id,
                msg_owner: msg_owner
            },
            beforeSend: function() {
                $("#msg_box" + msg_id).slideToggle();
            },
            success: function() {
                //nothing here
            }
        })
    });

    function fetch_online_user() {
        $.ajax({
            url: "/ajax/v2/messenger/v2/fetch_online_user.php",
            method: "POST",
            success: function(data) {
                //$('#online_users').html(data);
            }
        })
    }

    //VC SETUP 
    function init_video_call_box() {
        document.querySelector('#vdc_img').setAttribute('src', image_path);
        $("#vdc_username").html(username);
    }

    $(document).on('click', '#vcall_launcher', function(e) {
        $.ajax({
            url: "/ajax/v2/messenger/v2/video_call_status.php",
            method: "POST",
            data: {
                to_user_id: to_user_id
            },
            success: function(data) {
                window.location.href = "https://zungvi.com/vcall.php?u=" + to_user_id;
            }
        })
    });

    $(document).on('click', '#vcall_canceled', function(e) {
        $.ajax({
            url: "/ajax/v2/messenger/v2/video_call_cancel.php",
            method: "POST",
            data: {
                to_user_id: to_user_id
            },
            success: function(data) {
                console.log(data)
            }
        })
    });
</script>
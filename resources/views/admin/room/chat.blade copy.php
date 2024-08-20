<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>Room - {{ $room->code }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style type="text/css">
        body {
            overflow-y: hidden;
            margin-top: 100px;
            background-color: {{$cms->primary_color}}!important;
        }

        .chat-online {
            color: #34ce57
        }

        .chat-offline {
            color: #e4606d
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            max-height:750px;
            overflow-y: scroll;
            scrollbar-width: none; 
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0
        }

        .chat-message-left {
            margin-right: auto
        }

        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto
        }

        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .chat-room{
            display: none;
        }

        .qr{
            position: absolute;
            display: none;
            bottom: 0;
            left:10px
        }

        .btn-primary {
            color: #fff;
            background-color: {{$cms->secondary_color}};
            border-color: {{$cms->secondary_color}};
            box-shadow: 0 0.125rem 0.25rem 0 rgba(105, 108, 255, 0.4);
        }

        .navbar-top {
            background-color: {{$cms->secondary_color}} !important;
            color: #fff;
            position: fixed;
            top: 0;
            width: 100%;
            height: 80px;
            z-index: 1030;
            display: flex;
            align-items: center;
            padding: 0 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-top .navbar-brand {
            height: auto;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .navbar-top .form-inline {
            height: auto;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .navbar-top .form-control {
            max-width: 400px;
        }

        .input-container {
            position: fixed;
            bottom: 0;
            width: 41%;
            /* position: relative; */
        }

        .input-container .form-control.msg {
            background-color: #1E1E1E;
            color: #FFF;
            border: 1px solid #1E1E1E;
            border-radius: 10px;
            padding-right: 50px;
            resize: none;
        }

        .input-container .send-msg {
            position: absolute;
            right: 10px;
            bottom: 10px;
            background-color: {{$cms->primary_color}}!important;
            color: #FFF;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-container .send-upload {
            position: absolute;
            right: 60px;
            bottom: 10px;
            background-color: {{$cms->primary_color}}!important;
            color: #FFF;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-container .send-msg:hover {
            background-color: {{$cms->primary_color}}!important;
        }

        .input-container .send-msg:focus {
            outline: none;
            box-shadow: none;
        }

        .img_icon{
            max-width: 30%; /* Ensure the image doesn't exceed container width */
            height: auto; /* Maintain aspect ratio */
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
        
        #image-preview{
            max-width: 300px;
            max-height: 300px;
            float: right;
            margin-right: 26px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .area-image {
            display: none;
            position: fixed;
            bottom: 100px;
            right: 500px;
            z-index: 1000;
            max-width: 300px;
            max-height: 300px;
        }

        @media (max-width: 768px) {
            .navbar-top .navbar-brand {
                /* margin-left:  */
                /* align-items: center;
                justify-content: center;
                text-align: center; */
            }

            .navbar-top .form-inline {
                /* margin-right: 10px; */
                /* display: flex;
                justify-content: center;
                margin-top: 10px; */
            }

            /* .img_icon{
                align-items: center;
                justify-content: center;
            } */

            .input-container {
                width: 70%;
            }
            
            .area-image{
                right: 44px;    
            }

        }

        @media (max-width: 576px) {
            .input-group .send-msg {
                padding: 0.375rem;
            }

            .input-container {
                width: 81%;
            }
            
            .chat-messages {
                max-height: 550px;
            }
            
            .area-image{
                right: 44px;    
            }
            
        }

        .img-chat{
            width: 70%;
            border-radius: 10px;
        }

        .bg-custom{
            background-color: #ced6e0 !important;
        }
    </style>
</head>

<body>

    <div style="display:flex;justify-content:center;align-items:center;height:100vh;" class="container name-area">
        <div class="row">
            <div class="col-10 offset-1">
                <img class="img_icon"
                    src="{{ asset('/assets/image_content/'. $cms->logo ) }}">
                <div style="margin-top: 10%; background-color: {{$cms->primary_color}}!important;" class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" id="name" class="form-control name" placeholder="Type your name...">
                        </div>
                        <div style="margin-left:20px;" class="form-group">
                            <input type="checkbox" id="disclaimer" class="form-check-input">
                            <label style="color:#fff;" for="disclaimer" class="form-check-label disclaimer">
                                Disclaimer
                            </label><br>
                            <label style="color:#fff;" for="disclaimer" class="form-check-label disclaimer">
                                I am responsible for any text and image i see through this platform.
                            </label>
                        </div><br><br>
                        <div class="form-group">
                            <button style="width:100%" type="button" id="submit-btn" class="btn btn-primary">
                                Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="qr p-1">
        <div class="card">
            <div class="card-body">
                <center>
                    <h5><b>QR Code Room</b></h5>
                </center>
                {!! QrCode::size(200)->generate(url('/room/chat/'.$room->code)); !!}
                <center>
                    <small>*Scan untuk memasuki room chat</small>
                </center>
            </div>
        </div>
    </div>
    <main class="content chat-room">
        <div class="container-fluid p-0">
            <nav class="navbar navbar-light bg-light navbar-top">
                <a id="navbar-user-name" class="navbar-brand" href="#"></a>
                <form class="form-inline">
                    <img src="{{ asset('/assets/image_content/' . $cms->logo) }}" style="width:100px;" alt="Logo">
                </form>
            </nav>
        </div>
        <div style="display: flex;justify-content: center;align-items: center;" class="container p-0">
            <div class="card" style="background-color: {{$cms->primary_color}}!important;width:750px;">
                <div class="row g-0">
                    <div class="col-12">
                        <!-- <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-fill" viewBox="0 0 16 16">
                                        <path d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                      </svg>
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <strong>{{ $room->code }}</strong>
                                </div>
                            </div>
                        </div> -->
                        <div class="position-relative">
                            <div class="chat-messages p-4">
                                @foreach ($model as $item)
                                <div class="chat-message pb-4" data-id="{{ $item->id }}">
                                    <!-- <div>
                                        <img src="https://www.booksie.com/files/profiles/22/mr-anonymous.png"
                                            class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                                        <div class="text-muted small text-nowrap mt-2">{{ date('H:i', strtotime($item->created_at)) }}</div>
                                    </div> -->
                                    <div style="background-color: {{@$chat_contents->chat_color}}; border-radius:10px;" class="flex-shrink-1 rounded py-2 px-3 mr-3">
                                        <div class="font-weight-bold mb-1">{{ $item->name }}</div>
                                        @if ($item->image)
                                            <img style="max-width:300px;max-height:300px;" src="{{ asset($item->image) }}" alt="Image" class="img-chat">
                                        @else
                                        <div style="font-family: {{@$chat_contents->chat_font}}; color: {{ @$chat_contents->username_color }}">
                                            {{ $item->text }}
                                        </div>
                                        @endif
                                    </div>
                                    @if (!empty($item->reply))
                                        @foreach ($item->reply as $replyitem)
                                            <div class="flex-shrink-1 bg-custom text-dark rounded py-2 px-3 mr-3 mt-1 ml-3">
                                                <div class="font-weight-medium mb-1"><i>Balasan dari <b>Admin</b> kepada {{ $item->name }}</i></div>
                                                {{ @$replyitem->text }}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="area-image">
                            <div class="row">
                                <img id="image-preview" src="" alt="Image Preview"/>
                            </div>
                            <div class="row">
                                <button type="button" class="btn mx-1 change-image btn-sm btn-primary"><i class='fa fa-image' ></i></button>
                                <button type="button" class="btn mx-1 remove-image btn-sm btn-danger"><i class='fa fa-trash' ></i></button>
                                <button type="button" class="btn mx-1 upload-image btn-sm btn-success"><i class='fa fa-check' ></i></button>
                            </div>
                        </div>
                        <div class="flex-grow-0 py-3 px-4 field">
                            <div class="input-container">
                                <textarea id="chat-input" class="form-control msg" rows="3" placeholder="Type your message here..."></textarea>
                                <input type="file" id="chat-file" class="d-none" />
                                <button class="btn btn-primary send-upload" type="button">
                                    <i class="fa fa-image"></i>
                                </button>
                                <button class="btn btn-primary send-msg" type="button">
                                    <i class="fa fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        let flag_field = localStorage.getItem('flag-field');
        let flag_upload = false;

        $(document).ready(function(){
            let chatMessages = $('.chat-messages');
            chatMessages.scrollTop(chatMessages[0].scrollHeight);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let room_id = "{{ $room->id }}";
        let name = "";

        if (flag_field == "true" || flag_field == true) {
            $('.field').hide();
            $('.chat-room').show();
            $('.name-area').hide();
            $('.qr').hide();
            $('.navbar').hide();
            localStorage.removeItem('flag-field');
        }

        function scrollToBottom() {
            let chatMessages = $('.chat-messages');
            chatMessages.scrollTop(chatMessages[0].scrollHeight);
        }

        $('body').on('click', '.upload-image', function(){
            flag_upload = true;
            $('#chat-file').trigger('change');
        });

        $('body').on('click', '.change-image', function(){
            $('#chat-file').click();
        });

        $('body').on('click', '.remove-image', function(){
            $('.area-image').hide();
            $('#chat-input').val('');
        });

        $('#submit-btn').click(function(){
            name = $('#name').val();
            let disclaimerChecked = $('#disclaimer').is(':checked');
            
            if (name.trim() === '') {
                alert('Harap masukkan nama Anda.');
                return;
            }
            
            if (!disclaimerChecked) {
                alert('Anda harus menyetujui syarat dan ketentuan.');
                return;
            }

            $('.chat-room').show();
            $('.name-area').hide();
            $('.qr').hide();  // Menyembunyikan QR Code

            $('#navbar-user-name').text('@' + name);

            let chatMessages = $('.chat-messages');
            chatMessages.scrollTop(chatMessages[0].scrollHeight);
        });

        $('.send-upload').click(function(){
            $('#chat-file').click();
        });

        $('#chat-file').change(function(event) {
            let file = event.target.files[0];
            if (file) {
                // Check if the selected file is an image
                if (file.type.startsWith('image/') && flag_upload == false) {
                    let reader = new FileReader();
                    
                    // Load the image and display it in an img tag
                    reader.onload = function(e) {
                        $('#image-preview').attr('src', e.target.result);
                        $('#image-preview').show(); // Make sure the image preview is visible
                        $('.area-image').show();
                    };

                    reader.readAsDataURL(file); // Convert the file to a data URL
                }

                let formData = new FormData();
                formData.append('room_id', room_id);
                formData.append('name', name);
                formData.append('file', file);

                if (flag_upload == true) {
                    $.ajax({
                        url: "/api/send-file",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // Handle success response
                            console.log('File uploaded successfully.');
                            flag_upload = false;
                            $('.area-image').hide();
                            $('#chat-input').val(''); // Clear input after successful upload
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.log('Error uploading file.');
                        }
                    });
                }
            }
        });

        $('.send-msg').click(function(){
            // let msg = $('.msg').val();
            let msg = $('#chat-input').val();
            $('.send-msg').html('...');
            $.ajax({
                url : "/api/send-msg",
                type : "POST",
                data : {
                    room_id : room_id,
                    msg : msg,
                    name : name
                },
                success:function(res){
                    $('.msg').val('');
                    $('.send-msg').html('<i class="fa fa-paper-plane"></i>');
                }
            })
        });

        // autoload
        setInterval(() => {
            $.ajax({
                url : "/api/get-msg",
                type : "POST",
                data : {
                    id : room_id,
                },
                success:function(res){
                    let shouldScroll = false;
                    res.forEach(item => {
                        // Check if the message already exists
                        if (!$(`.chat-message[data-id="${item.id}"]`).length) {

                            console.log(item);

                            shouldScroll = true;
                            // Extract and format the hour from created_at
                            let date = new Date(item.created_at);
                            let hours = date.getHours();
                            let minutes = date.getMinutes();
                            hours = hours;
                            minutes = minutes < 10 ? '0'+minutes : minutes;
                            let formattedTime = hours + ':' + minutes;

                            let avatarUrl = `https://www.booksie.com/files/profiles/22/mr-anonymous.png`;

                            let final_content = "";
                            if (item.text == "" || item.text == null) {
                                final_content = `<img class="img-chat" src="{{ asset('${item.image}') }}">`;
                            }else{
                                final_content = item.text;
                            }

                            let newMessage = `
                                <div class="chat-message mt-3" data-id="${item.id}">
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                        <div class="font-weight-bold mb-1">${item.name}</div>
                                        <div style="font-family: {{@$chat_contents->chat_font}}; color: {{ @$chat_contents->username_color }}" >${final_content}</div>
                                    </div>
                                </div>
                            `;

                            if(item.reply != null){
                                $.each(item.reply, function(k, v){
                                    newMessage += `<div class="flex-shrink-1 bg-custom text-dark rounded py-2 px-3 mr-3 mt-1 ml-3">
                                                        <div class="font-weight-medium mb-1"><i>Balasan dari <b>Admin</b> kepada ${item.name}</i></div>
                                                        ${v.text}
                                                    </div>`;
                                });
                            }

                            // Append the new message
                            $('.chat-messages').append(newMessage);
                        }
                    });
                    if (shouldScroll) {
                        let chatMessages = $('.chat-messages');
                        chatMessages.scrollTop(chatMessages[0].scrollHeight);
                    }
                }
            })

        }, 500);
    </script>
</body>

</html>
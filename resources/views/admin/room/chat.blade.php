<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Room -
            {{ $room->code }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <style>
        body {
            overflow-y: hidden;
            /* font-family: 'Roboto', sans-serif; */
            margin: 0;
            padding: 0;
            <?php if ($cms->image): ?>
                background-image: url('<?php echo $cms->image ? "/assets/image_content/" . $cms->image : ""; ?>');
                background-repeat: no-repeat;
                background-size: cover;
            <?php else: ?>
                background-color: {{$cms->primary_color}};
            <?php endif; ?>
        }

        .chat-room{
            display: none;
        }

        .chat-container {
            height: 100vh;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container > h1 {
            padding: 10px;
            color: white;
        }

        .logo {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .img_icon{
            max-width: 30%;
            height: auto;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 10px;
            height: 60px;
            background-color: #171717;
        }

        .chat-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chat-box {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .chat-box p {
            margin: 10px 0;
            font-size: 16px;
        }

        .navbar-top .form-control {
            max-width: 400px;
        }

        .input-container {
            display: flex;
            padding: 15px;
            border-top: 0.01px solid #5c5b5b;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border-radius: 30%;
            border: 1px solid #ccc;
            background-color: #1e1e1e;
            border-radius: 5px 0 0 5px;
            outline: none;
        }

        .light-mode input {
            color: #171717;
            background-color: #f9f9f9;
        }

        .dark-mode input {
            color: #ddd;
            background-color: #1d1c1c;
        }

        .light-mode button {
            color: #171717;
            background-color: #f9f9f9;
        }

        button {
            padding: 10px 20px;
            border: none;
            border: 1px solid #ccc;
            background-color: #1d1c1c;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .card {
            background-color: #3d3d3d;
            margin: 10px;
            border-radius: 8px;
            padding: 10px;
            color: white;
            z-index: 2;
        }

        .reply {
            background-color: #e1e1e1;
            margin: -16px 10px 10px;
            border-bottom-right-radius: 8px;
            border-bottom-left-radius: 8px;
            border-top-left-radius: 8px;
            padding: 10px;
            color: #3d3d3d;
            z-index: 999;
        }

        .svg-icon {
            width: 2em;
            height: 2em;
        }

        .svg-icon path,
        .svg-icon polygon,
        .svg-icon rect {
            fill: #3d3d3d;
        }

        .svg-icon circle {
            stroke: #3d3d3d;
            stroke-width: 1;
        }

        .d-none{
            display: none;
        }

        .preview-image-area {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            overflow-y: auto;
            padding: 15px;
        }

        .preview-image-area > #image-preview{
            display: none;
            width: 300px;
            border-radius: 10px;
        }

        .remove-image{
            font-size: 5px;
            background-color: red;
            padding: 6px;
            border-radius: 100%;
            color: white !important;
            position: absolute;
            margin: 5px;
            display: none
        }

        .remove-image > .svg-icon path,
        .svg-icon polygon,
        .svg-icon rect {
            fill: #ffffff;
        }

        .remove-image > .svg-icon circle {
            stroke: #ffffff;
            stroke-width: 1;
        }

        .img-chat{width:300px;height:300px;margin-top:10px;border-radius:10px}
    </style>

    <body>
        <div style="display:flex;justify-content:center;align-items:center;height:100vh;" class="container name-area">
            <div class="row">
                <div class="col-10 offset-1">
                    <img class="img_icon"
                        src="{{ asset('/assets/image_content/'. $cms->logo ) }}">
                    <div style="margin-top: 10%; background-color: {{$cms->primary_color}}!important;" class="card alert-name-section">
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
        <div class="chat-container chat-room light-mode">
            <div class="chat-content">
                <div class="chat-header">
                    <div class="logo-container">
                        <h1>
                            <img class="img-logo" src="{{ asset('/assets/image_content/' . $cms->logo) }}" style="width:100px;" alt="Logo">
                        </h1>
                    </div>
                </div>
                <div class="chat-box" id="chat-box">
                    @foreach ($model as $item)
                        <div style="background-color: {{ @$chat_contents->chat_color }}" class="card chat-message" data-id="{{ $item->id }}">
                            <b style="font-size:{{ @$chat_contents->chat_sizeName }}px;" class="size-name">{{ $item->name }}</b>
                            @if ($item->image)
                                <br><img src="{{ asset($item->image) }}" alt="Image" class="img-chat">
                                <p class="item-text" style="font-family: {{@$chat_contents->chat_font}}; color: {{ @$chat_contents->username_color }}; font-size:{{ @$chat_contents->chat_size }}px">{{ $item->text }}</p>
                            @else
                                <p class="item-text" style="font-family: {{@$chat_contents->chat_font}}; color: {{ @$chat_contents->username_color }}; font-size:{{ @$chat_contents->chat_size }}px">{{ $item->text }}</p>
                            @endif
                        </div>
                        @if (!empty($item->reply))
                            @foreach ($item->reply as $replyitem)
                                <div class="reply">
                                    <!--<i>Balasan dari <b>Admin</b> kepada {{ $item->name }}</i><br>-->
                                    {{ @$replyitem->text }}
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>

                <!-- Preview image -->
                <div class="preview-image-area">
                    <span class="remove-image">
                        <svg class="svg-icon" viewBox="0 0 20 20">
							<path fill="none" d="M11.469,10l7.08-7.08c0.406-0.406,0.406-1.064,0-1.469c-0.406-0.406-1.063-0.406-1.469,0L10,8.53l-7.081-7.08
							c-0.406-0.406-1.064-0.406-1.469,0c-0.406,0.406-0.406,1.063,0,1.469L8.531,10L1.45,17.081c-0.406,0.406-0.406,1.064,0,1.469
							c0.203,0.203,0.469,0.304,0.735,0.304c0.266,0,0.531-0.101,0.735-0.304L10,11.469l7.08,7.081c0.203,0.203,0.469,0.304,0.735,0.304
							c0.267,0,0.532-0.101,0.735-0.304c0.406-0.406,0.406-1.064,0-1.469L11.469,10z"></path>
						</svg>
                    </span>
                    <img id="image-preview" src="" alt="Image Preview"/>
                </div>

                <div class="input-container">
                    <input type="text" id="chat-input" class="msg" placeholder="Type your message...">
                    <input type="file" id="chat-file" class="d-none" />
                    <button class="send-upload">
                        <svg class="svg-icon" viewbox="0 0 20 20">
                            <path
                                d="M10,6.536c-2.263,0-4.099,1.836-4.099,4.098S7.737,14.732,10,14.732s4.099-1.836,4.099-4.098S12.263,6.536,10,6.536M10,13.871c-1.784,0-3.235-1.453-3.235-3.237S8.216,7.399,10,7.399c1.784,0,3.235,1.452,3.235,3.235S11.784,13.871,10,13.871M17.118,5.672l-3.237,0.014L12.52,3.697c-0.082-0.105-0.209-0.168-0.343-0.168H7.824c-0.134,0-0.261,0.062-0.343,0.168L6.12,5.686H2.882c-0.951,0-1.726,0.748-1.726,1.699v7.362c0,0.951,0.774,1.725,1.726,1.725h14.236c0.951,0,1.726-0.773,1.726-1.725V7.195C18.844,6.244,18.069,5.672,17.118,5.672 M17.98,14.746c0,0.477-0.386,0.861-0.862,0.861H2.882c-0.477,0-0.863-0.385-0.863-0.861V7.384c0-0.477,0.386-0.85,0.863-0.85l3.451,0.014c0.134,0,0.261-0.062,0.343-0.168l1.361-1.989h3.926l1.361,1.989c0.082,0.105,0.209,0.168,0.343,0.168l3.451-0.014c0.477,0,0.862,0.184,0.862,0.661V14.746z"></path>
                        </svg>
                    </button>
                    <button id="send-button" class="send-msg">
                        <svg class="svg-icon" viewbox="0 0 20 20">
                            <path
                                d="M17.218,2.268L2.477,8.388C2.13,8.535,2.164,9.05,2.542,9.134L9.33,10.67l1.535,6.787c0.083,0.377,0.602,0.415,0.745,0.065l6.123-14.74C17.866,2.46,17.539,2.134,17.218,2.268 M3.92,8.641l11.772-4.89L9.535,9.909L3.92,8.641z M11.358,16.078l-1.268-5.613l6.157-6.157L11.358,16.078z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript">
        let flag_field = localStorage.getItem('flag-field');
        let flag_upload = false;

        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function toBottom(){
                let chatMessages = $('.chat-box');
                chatMessages.scrollTop(chatMessages[0].scrollHeight + 200);
            }

            toBottom();

            let room_id = "{{ $room->id }}";
            let name = "";
            let flag_field = localStorage.getItem('flag-field');
            let flag_upload = false;

            $('.preview-image-area').hide();

            if (flag_field == "true" || flag_field == true) {
                $('.field').hide();
                $('.chat-room').show();
                $('.name-area').hide();
                $('.qr').hide();
                $('.chat-header').hide();
                $('.input-container').hide();
                localStorage.removeItem('flag-field');
            }

            $('.send-upload').click(function(){
                $('#chat-file').click();
                $('.preview-image-area').show();
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
                            $('.remove-image').show();
                        };

                        reader.readAsDataURL(file); // Convert the file to a data URL
                    }
                }
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

                toBottom();
            });

            $('.send-msg').click(function(){
                // Get the message input
                let msg = $('#chat-input').val();

                // Create a FormData object to handle both the text and the file
                let formData = new FormData();
                formData.append('room_id', room_id);
                formData.append('msg', msg);
                formData.append('name', name);

                // Check if there's a file selected
                let fileInput = $('#chat-file')[0]; // Assuming there's a file input with id="chat-file"
                let file = fileInput.files[0];

                if (file && file.type.startsWith('image/')) {
                    formData.append('file', file);
                }

                // Set the button text to indicate sending
                $('.send-msg').html('...');

                // Send the AJAX request
                $.ajax({
                    url: "/api/send-msg",  // Assuming your API can handle both message and file
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        // Clear the input fields
                        $('#chat-input').val('');
                        $('#chat-file').val(''); // Clear the file input

                        // Reset the button text
                        $('.send-msg').html('<i class="fa fa-paper-plane"></i>');

                        // Optionally, hide the image preview after successful upload
                        $('#image-preview').hide();
                        $('.area-image').hide();
                        $('.remove-image').hide();
                        toBottom();
                    }
                });
            });

            $('.remove-image').click(function(){
                $('#chat-file').val(''); // Clear the file input

                // Optionally, hide the image preview after successful upload
                $('#image-preview').hide();
                $('.area-image').hide();
                $('.remove-image').hide();
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
                                shouldScroll = true;
                                // Extract and format the hour from created_at
                                let date = new Date(item.created_at);
                                let hours = date.getHours();
                                let minutes = date.getMinutes();
                                hours = hours;
                                minutes = minutes < 10 ? '0'+minutes : minutes;
                                let formattedTime = hours + ':' + minutes;
                                let avatarUrl = `https://www.booksie.com/files/profiles/22/mr-anonymous.png`;

                                // get cms setup
                                $.ajax({
                                    url : "{{ url('api/get-cms') }}",
                                    type : "GET",
                                    cache: false,
                                    success:function(res){
                                        console.log(res);
                                        
                                        let final_content = `<p class="item-text" style="font-family: ${res.dynamic_content.chat_font}; color: ${res.dynamic_content.username_color}; font-size:${res.dynamic_content.chat_size}px">${item.text}</p>`;
                                
                                        if (item.image) {
                                            final_content = `<br><img class="img-chat" src="{{ asset('${item.image}') }}">`;
                                            final_content += `<p class="item-text" style="font-family: ${res.dynamic_content.chat_font}; color: ${res.dynamic_content.username_color}; font-size:${res.dynamic_content.chat_size}px">${item.text}</p>`;
                                        }

                                        let newMessage = `
                                            <div style="background-color: ${res.dynamic_content.chat_color}" class="card chat-message" data-id="${item.id}">
                                                <b style="font-size:${res.dynamic_content.chat_sizeName}px;" class="size-name">${item.name}</b>
                                                ${final_content}
                                            </div>
                                        `;

                                        if(item.reply != null){
                                            $.each(item.reply, function(k, v){
                                                newMessage += `<div class="reply">
                                                                    ${v.text}
                                                                </div>`;
                                            });
                                        }

                                        // Append the new message
                                        $('.chat-box').append(newMessage);
                                    }
                                });
                                setTimeout(() => {
                                    toBottom();
                                }, 500);
                            }
                        });
                        if (shouldScroll) {
                            toBottom();
                        }
                    }
                });

                // dynamic cms
                getCms();
            }, 500);

            let previousValues = {
                chat_color: "",
                chat_sizeName: "",
                chat_size: "",
                chat_font: "",
                username_color: "",
                logo: "",
                primary_color: ""
            };

            function getCms(){
                $.ajax({
                    url : "{{ url('api/get-cms') }}",
                    type : "GET",
                    cache: false,
                    success:function(res){
                        changeLayout(res);
                    }
                });
            }

            function hasChanged(newVal, oldVal) {
                return JSON.stringify(newVal) !== JSON.stringify(oldVal);
            }

            function changeLayout(res) {
                let newValues = {
                    chat_color: res.dynamic_content.chat_color,
                    chat_sizeName: res.dynamic_content.chat_sizeName,
                    chat_size: res.dynamic_content.chat_size,
                    chat_font: res.dynamic_content.chat_font,
                    username_color: res.dynamic_content.username_color,
                    logo: res.dynamic_cms.logo,
                    primary_color: res.dynamic_cms.primary_color
                };

                // Check if anything changed
                if (hasChanged(newValues, previousValues)) {
                    // Update the DOM with new values
                    updateDOM(newValues);
                    // Update previousValues to newValues after changes
                    previousValues = {...newValues}; // Use spread operator to create a new object
                }
            }

            function updateDOM(values) {
                if (values.chat_color !== previousValues.chat_color) {
                    $('.chat-message').css('background-color', values.chat_color);
                }
                if (values.chat_sizeName !== previousValues.chat_sizeName) {
                    $('.size-name').css('font-size', values.chat_sizeName + 'px !important');
                }
                if (values.chat_size !== previousValues.chat_size) {
                    console.log('harusnya berubah menjadi ' + values.chat_size);
                    
                    $('.item-text').css('font-size', values.chat_size + 'px !important');
                }
                if (values.chat_font !== previousValues.chat_font) {
                    $('.item-text').css('font-family', values.chat_font);
                }
                if (values.username_color !== previousValues.username_color) {
                    $('.item-text').css('color', values.username_color);
                }
                if (values.logo !== previousValues.logo) {
                    $('.img-logo').attr('src', "{{ asset('/assets/image_content') }}" + "/" + values.logo);
                    $('.img_icon').attr('src', "{{ asset('/assets/image_content') }}" + "/" + values.logo);
                }
                if (values.primary_color !== previousValues.primary_color) {
                    $('.alert-name-section').css('background-color', values.primary_color);
                    $('body').css('background-color', values.primary_color);
                }
            }

        });
    </script>

</html>

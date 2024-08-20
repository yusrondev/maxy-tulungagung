<!DOCTYPE html>
<html lang="en">
<head>
  <title>Chat Laravel Pusher | Edlin App</title>
  <link rel="icon" href="https://assets.edlin.app/favicon/favicon.ico"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- JavaScript -->
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <!-- End JavaScript -->

  <!-- CSS -->
  <link rel="stylesheet" href="/style.css">
  <!-- End CSS -->

  <style>
    /* Additional inline CSS for layout adjustments */
    .chat {
      display: flex;
      flex-direction: column;
      height: 100vh;
      max-width: 800px;
      margin: 0 auto;
      border: 1px solid #ddd;
      border-radius: 10px;
      overflow: hidden;
    }

    .top {
      display: flex;
      align-items: center;
      padding: 10px;
      background-color: #f1f1f1;
      border-bottom: 1px solid #ddd;
    }

    .top p {
      margin: 0;
      font-weight: bold;
    }

    .messages {
      flex: 1;
      overflow-y: auto;
      padding: 10px;
      background-color: #fff;
    }

    .message {
      clear: both;
      margin: 5px 0;
      padding: 10px;
      border-radius: 10px;
      max-width: 70%;
    }

    .message.own {
      background-color: #e1ffc7;
      margin-left: auto;
      text-align: right;
    }

    .message.own p {
      margin: 0;
      display: inline-block;
    }

    .message:not(.own) {
      background-color: #f1f0f0;
      margin-right: auto;
    }

    .message:not(.own) p {
      margin: 0;
      display: inline-block;
    }

    .bottom {
      padding: 10px;
      background-color: #f1f1f1;
      border-top: 1px solid #ddd;
    }

    .bottom form {
      display: flex;
    }

    .bottom input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .bottom button {
      padding: 10px;
      border: none;
      background-color: #007bff;
      color: white;
      border-radius: 5px;
      margin-left: 10px;
      cursor: pointer;
    }

    .bottom button:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
<div class="chat">

  <!-- Header -->
  <div class="top">
    <div>
      <p>{{ session('user_name') }}</p>
      <small>Online</small>
    </div>
  </div>
  <!-- End Header -->

  <!-- Chat -->
  <div class="messages">
    @include('receive', ['message' => "Hey! What's up!  👋", 'isOwnMessage' => false, 'name' => 'Ross Edlin'])
    @include('receive', ['message' => "Ask a friend to open this link and you can chat with them!", 'isOwnMessage' => false, 'name' => 'Ross Edlin'])
  </div>
  <!-- End Chat -->

  <!-- Footer -->
  <div class="bottom">
    <form>
      <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
      <button type="submit">Send</button>
    </form>
  </div>
  <!-- End Footer -->

</div>
</body>

<script>
  const pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
    cluster: 'eu'
  });
  const channel = pusher.subscribe('public');

  // Receive messages
  channel.bind('chat', function (data) {
    $.post("/receive", {
      _token: '{{csrf_token()}}',
      message: data.message,
      isOwnMessage: data.isOwnMessage,
      name: data.name
    }).done(function (res) {
      $(".messages").append(res);
      $(document).scrollTop($(document).height());
    });
  });

  // Broadcast messages
  $("form").submit(function (event) {
    event.preventDefault();

    const message = $("form #message").val();
    $.ajax({
      url: "/broadcast",
      method: 'POST',
      headers: {
        'X-Socket-Id': pusher.connection.socket_id
      },
      data: {
        _token: '{{csrf_token()}}',
        message: message,
        isOwnMessage: true,
        name: "{{ session('user_name') }}"
      }
    }).done(function (res) {
      $(".messages").append(res);
      $("form #message").val('');
      $(document).scrollTop($(document).height());
    });
  });
</script>
</html>
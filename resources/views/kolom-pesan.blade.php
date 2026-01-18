<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Bootstrap 5 Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f1f3f5;
        }

        .chat-container {
            max-width: 500px;
            height: 600px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
        }

        .chat-body {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
        }

        .chat-footer {
            padding: 10px;
            border-top: 1px solid #e9ecef;
        }

        .message {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 12px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .message.user {
            background: #0d6efd;
            color: #fff;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }

        .message.admin {
            background: #e9ecef;
            color: #000;
            margin-right: auto;
            border-bottom-left-radius: 4px;
        }

        .chat-time {
            font-size: 11px;
            opacity: .6;
            margin-top: 3px;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="chat-container">

            <!-- Header -->
            <div class="chat-header">
                💬 Live Chat
            </div>

            <!-- Body -->
            <div class="chat-body">

              @if(isset($msg->user))
                <div class="message user">
                    {{$msg->user}}
                    <div class="chat-time">{{ date('H:i') }}</div>
                </div>
                @endif
                @if(isset($msg->admin))
                <div class="message admin">
                    {!!  $msg->admin !!}
                    <div class="chat-time">{{ date('H:i') }}</div>
                </div>
                @endif

            </div>

            <!-- Footer -->
            <div class="chat-footer">
                <form class="d-flex gap-2" action="/api/webhook/message?from={{ request('from','6282315192789') }}" method="post">
                    @csrf
                    <input type="hidden" name="from" value="{{ request('from','6282315192789') }}">
                    <input type="text" name="message" class="form-control" placeholder="Tulis pesan...">
                    <button class="btn btn-primary">Kirim</button>
                </form>
            </div>

        </div>
    </div>

</body>

</html>
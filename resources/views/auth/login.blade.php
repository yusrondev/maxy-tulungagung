<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('/assets/css/login/stylee.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/boxicons.css') }}" />

    <style>
        body{
            margin:0;
            height: 100vh;
            width: 100vw;
            overflow:hidden;
            display: flex;
            align-items: center;
            color: {{ @$cms->secondary_color }} !important;
            background-color: #fff;
            justify-content: center;
            background-image: url('https://wallpapers.com/images/hd/1280x720-gaming-0yhvmfxag0yu5r34.jpg');
            background-size: cover;
        }
        .submit{
            outline: none;
            border: none;
            width: 100%;
            height: 60px;
            border-radius: 30px;
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            background-color: {{ @$cms->secondary_color }} !important;
            background-size: 200%;
            box-shadow: 3px 3px 8px #b1b1b1,
                        -3px -3px 8px #fff;
            transition: .5s;
        }
    </style>
</head>
<body>
    <div class="main" style="">
        <div class="logo"><img style="width:200px;margin-top:30px;" src="{{ asset('/assets/image_content/' . @$cms->logo) }}"></div>
        <div class="title">{{ @$cms->website_name }}</div>
        <form method="POST" action="{{ route('login') }}">
        @csrf
            <div class="credentials">
                <div class="username">
                    <i class='bx bxs-envelope'></i>
                    <input type="mail" name="email" placeholder="Email" required="">
                </div>
                <div class="password">
                    <i class='bx bxs-lock'></i>
                    <input type="password" name="password" placeholder="password" required="">
                </div>
            </div>
            <button class="submit">Submit</submit>
        </form>
    </div>
</body>
</html>

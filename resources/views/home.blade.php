<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

  <style>
    html, body { height: 100%; margin: 0; }
    body { font-family: Arial, sans-serif; }

    .home-page{
      min-height:100vh;
      background-image: url("{{ asset('images/backgorud.jpg') }}");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
      overflow: hidden;
    }

    .home-login-btn{
      position:absolute;
      top:24px;
      left:24px;
      padding:10px 22px;
      background:#fff;
      border:2px solid #000;
      border-radius:999px;
      font-weight:700;
      color:#000;
      text-decoration:none;
      display:inline-block;
    }

    .home-text{
      position:absolute;
      top:40px;
      right:40px;
      text-align:right;
      color:#000;
      max-width: 900px;
    }

    .home-title{
      font-size:54px;
      font-weight:900;
      line-height:1.05;
    }

    .home-subtitle{
      font-size:40px;
      font-weight:900;
      line-height:1.05;
    }

    .home-logo{
      margin-top:18px;
      height:100px;
    }

    @media (max-width: 768px){
      .home-text{ right:16px; left:16px; text-align:center; }
      .home-title{ font-size:36px; }
      .home-subtitle{ font-size:26px; }
      .home-login-btn{ top:16px; left:16px; }
      .home-logo{ height:60px; }
    }
  </style>
</head>

<body>
  <section class="home-page">
    <a href="{{ route('login') }}" class="home-login-btn">Login</a>

    <div class="home-text">
      <div class="home-title">Selamat datang</div>
      <div class="home-subtitle">Di Website Manajemen Magang</div>

      <img src="{{ asset('images/bank.png') }}" class="home-logo" alt="Bank Nagari">
    </div>
  </section>
</body>
</html>

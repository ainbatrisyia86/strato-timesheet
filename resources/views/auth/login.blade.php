<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Log In</title>
  <style>
    /* Reset & base styles */
    * {
      box-sizing: border-box;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }

    body {
      margin: 0;
      background: #222;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }

    /* Card container */
    .card {
      width: 900px;
      height: 520px;
      background: #fff;
      display: flex;
      overflow: hidden;
      border-radius: 4px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    /* Left panel */
    .left {
      width: 45%;
      background: #eee;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px;
    }

    .left img {
      max-width: 85%;
      height: auto;
    }

    /* Right panel */
    .right {
      width: 55%;
      padding: 48px 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: #fff;
    }

    .title {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 28px;
      color: #111;
    }

    /* Form */
    form {
      width: 72%;
    }

    /* Input field */
    .input {
      background: #f3f3f3;
      border-radius: 14px;
      padding: 8px 16px;
      display: flex;
      align-items: center;
      margin-bottom: 16px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
      min-height: 40px;
    }

    .input svg {
      width: 20px;
      height: 20px;
      opacity: 0.45;
      margin-right: 10px;
      display: block;
    }

    .input input {
      border: 0;
      background: transparent;
      outline: none;
      font-size: 15px;
      width: 100%;
      height: 100%;
      padding: 6px 0;
    }

    /* Button */
    .btn {
      display: block;
      margin: 14px auto 0 auto; /* centers button */
      width: 100%; /* full width of form */
      background: #66c5f2;
      border-radius: 22px;
      padding: 12px 28px;
      text-align: center;
      color: #fff;
      font-weight: 600;
      border: none;
      cursor: pointer;
      box-shadow: 0 6px 12px rgba(13,59,102,0.12);
    }

    /* Error message */
    .error {
      color: #c0392b;
      font-size: 14px;
      margin-bottom: 12px;
    }

    /* Helper text */
    .helper {
      font-size: 13px;
      color: #777;
      margin-top: 10px;
      text-align: center;
    }

    /* Responsive for smaller screens */
    @media (max-width: 880px) {
      .card {
        flex-direction: column;
        height: auto;
        width: 100%;
      }

      .left, .right {
        width: 100%;
      }

      .right {
        padding: 28px;
      }

      form {
        width: 100%;
      }

      .btn {
        width: 100%;
      }
    }

  </style>
</head>
<body>

  <div class="card">
    <div class="left">
      <img src="{{ asset('images/strato_logo.png') }}" alt="Strato Solutions Logo">
    </div>

    <div class="right">
      <div class="title">Log In</div>

      @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ url('/login') }}">
        @csrf

        <div class="input">
          <!-- email icon -->
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 7.5v9A2.5 2.5 0 0 0 5.5 19h13a2.5 2.5 0 0 0 2.5-2.5v-9" stroke="#444" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="input">
          <!-- lock icon -->
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="3" y="11" width="18" height="10" rx="2" stroke="#444" stroke-width="1.2"/>
            <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="#444" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <input type="password" name="password" placeholder="Password" required>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:6px; margin-bottom:8px;">
          <label style="font-size:13px;color:#666;">
            <input type="checkbox" name="remember" style="margin-right:6px"> Remember me
          </label>
          <a href="#" style="font-size:13px;color:#0D3B66;text-decoration:none;">Forgot?</a>
        </div>

        <button type="submit" class="btn">Log In</button>

      </form>
    </div>
  </div>

</body>
</html>

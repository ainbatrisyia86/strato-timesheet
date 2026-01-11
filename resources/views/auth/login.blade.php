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
    <!-- left: logo -->
  <div class="card">
    <div class="left">
      <img src="{{ asset('images/strato_logo.png') }}" alt="Strato Solutions Logo">
    </div>

    <!-- right: login form -->
    <div class="right">
      <div class="title">Log In</div>

    <!-- display first validation error -->
      @if ($errors->any() && !session('login_lock_seconds'))
        <div class="error">{{ $errors->first() }}</div>
      @endif

      <!-- Display session success message -->
      @if(session('success'))
          <script>
              alert("{{ session('success') }}");
              // Optionally, redirect after OK
              // window.location.href = "{{ route('login') }}"; 
          </script>
      @endif


      <form method="POST" action="{{ url('/login') }}">
        @csrf

        <!-- email input -->
        <div class="input">
          <!-- email icon -->
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 7.5v9A2.5 2.5 0 0 0 5.5 19h13a2.5 2.5 0 0 0 2.5-2.5v-9" stroke="#444" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
        </div>

        <!-- password input -->
        <div class="input" style="position:relative;">
          <!-- lock icon -->
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="3" y="11" width="18" height="10" rx="2" stroke="#444" stroke-width="1.2"/>
            <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="#444" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>

          <input type="password" name="password" placeholder="Password" required style="padding-right:32px;" id="password-field">
        
          <!-- eye icon button -->
          <span id="toggle-password" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); cursor:pointer; opacity:0.6;">
            <!-- Eye icon (you can replace with any SVG) -->
            
            <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5
                  c4.478 0 8.268 2.943 9.542 7
                  -1.274 4.057-5.064 7-9.542 7
                  -4.477 0-8.268-2.943-9.542-7z"/>
            </svg>

            <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20" style="display:none;">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19 c-4.478 0-8.268-2.943-9.543-7 a9.97 9.97 0 012.188-3.264"/>
            </svg>

          </span>
        </div>

        <!-- remember me & forgot password -->
        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:6px; margin-bottom:8px;">
          <label style="font-size:13px;color:#666;">
            <input type="checkbox" name="remember" style="margin-right:6px"> Remember me
          </label>
          <a href="{{ route('password.request') }}" style="font-size:13px;color:#0D3B66;text-decoration:none;">Forgot?</a>
        </div>

    @if(session('login_lock_seconds'))
      <p class="error">
          Too many login attempts. Please try again in 
          <span id="countdown"></span>.
      </p>

      <script>
          let countdown = {{ session('login_lock_seconds') }};
          const countdownEl = document.getElementById('countdown');
          const loginButton = document.querySelector('button[type="submit"]');
          
          if (loginButton) loginButton.disabled = true;

          const updateDisplay = (s) => {
              // This ensures it shows "53 seconds" or "1:00" instead of just "53"
              if (s < 60) {
                  countdownEl.innerText = s + " seconds";
              } else {
                  const m = Math.floor(s / 60);
                  const sec = s % 60;
                  countdownEl.innerText = `${m}:${sec < 10 ? '0' : ''}${sec}`;
              }
          };

          updateDisplay(countdown);

          const interval = setInterval(() => {
              countdown--;
              if (countdown <= 0) {
                  clearInterval(interval);
                  countdownEl.innerText = "0 seconds";
                  if (loginButton) loginButton.disabled = false;
                  // Optional: refresh page to clear error state
                  // window.location.reload(); 
              } else {
                  updateDisplay(countdown);
              }
          }, 1000);
      </script>
  @endif

        <!-- submit button -->
        <button type="submit" class="btn">Log In</button>

        

      </form>
    </div>
  </div>

  <!-- ===========================
       Toggle password visibility
  =========================== -->
  <script>
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password-field');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');

    togglePassword.addEventListener('click', () => {
      if(passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'block';
      } else {
        passwordField.type = 'password';
        eyeOpen.style.display = 'block';
        eyeClosed.style.display = 'none';
      }
    });
  </script>
  
</body>
</html>

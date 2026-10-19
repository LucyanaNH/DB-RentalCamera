<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - Rental Kamera</title>


    <!-- Google Font -->

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }


        body {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 20px;

            background:
                linear-gradient(
                    rgba(10, 12, 18, 0.78),
                    rgba(10, 12, 18, 0.88)
                ),
                url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=1920&q=85');

            background-size: cover;

            background-position: center;

            background-repeat: no-repeat;

        }


        /* =========================
           LOGIN CARD
           ========================= */

        .login-box {

            width: 100%;

            max-width: 420px;

            padding: 42px 38px;

            background: rgba(20, 23, 32, 0.88);

            border: 1px solid rgba(255, 255, 255, 0.10);

            border-radius: 20px;

            backdrop-filter: blur(15px);

            -webkit-backdrop-filter: blur(15px);

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.45);

            animation: muncul 0.5s ease;

        }


        @keyframes muncul {

            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        /* =========================
           LOGO / ICON
           ========================= */

        .login-icon {

            width: 62px;

            height: 62px;

            margin: 0 auto 18px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 16px;

            background: rgba(243, 156, 18, 0.12);

            border: 1px solid rgba(243, 156, 18, 0.25);

            color: #f39c12;

        }


        .login-icon svg {

            width: 30px;

            height: 30px;

        }


        /* =========================
           TITLE
           ========================= */

        .login-box h2 {

            color: #ffffff;

            text-align: center;

            font-size: 1.65rem;

            font-weight: 600;

            margin-bottom: 7px;

            letter-spacing: 0.5px;

        }


        .login-box h2 span {

            color: #f39c12;

        }


        .login-subtitle {

            color: #94a3b8;

            text-align: center;

            font-size: 0.82rem;

            margin-bottom: 32px;

        }


        /* =========================
           ALERT
           ========================= */

        .alert-error {

            display: flex;

            align-items: center;

            gap: 9px;

            background: rgba(239, 68, 68, 0.10);

            border: 1px solid rgba(239, 68, 68, 0.30);

            color: #f87171;

            padding: 11px 13px;

            border-radius: 10px;

            font-size: 0.78rem;

            margin-bottom: 25px;

        }


        .alert-error svg {

            width: 17px;

            height: 17px;

            flex-shrink: 0;

        }


        /* =========================
           INPUT
           ========================= */

        .input-group {

            position: relative;

            margin-bottom: 25px;

        }


        .input-group input {

            width: 100%;

            height: 50px;

            padding: 0 14px;

            padding-top: 7px;

            color: #ffffff;

            background: #181c2a;

            border: 1px solid #2d3748;

            border-radius: 10px;

            outline: none;

            font-size: 0.86rem;

            transition: all 0.2s ease;

        }


        .input-group input:hover {

            border-color: rgba(243, 156, 18, 0.35);

        }


        .input-group input:focus {

            border-color: #f39c12;

            box-shadow:
                0 0 0 3px rgba(243, 156, 18, 0.08);

        }


        .input-group label {

            position: absolute;

            left: 14px;

            top: 15px;

            color: #64748b;

            font-size: 0.84rem;

            pointer-events: none;

            transition: all 0.2s ease;

            background: #181c2a;

            padding: 0 4px;

        }


        /* Label naik ketika input aktif / terisi */

        .input-group input:focus ~ label,
        .input-group input:valid ~ label {

            top: -8px;

            left: 10px;

            color: #f39c12;

            font-size: 0.70rem;

        }


        /* =========================
           BUTTON
           ========================= */

        .btn-submit {

            width: 100%;

            height: 46px;

            margin-top: 5px;

            border: none;

            border-radius: 10px;

            background: #f39c12;

            color: #111827;

            font-size: 0.84rem;

            font-weight: 700;

            letter-spacing: 0.5px;

            cursor: pointer;

            transition: all 0.2s ease;

            box-shadow:
                0 5px 15px rgba(243, 156, 18, 0.20);

        }


        .btn-submit:hover {

            background: #ffad25;

            transform: translateY(-1px);

            box-shadow:
                0 8px 20px rgba(243, 156, 18, 0.30);

        }


        .btn-submit:active {

            transform: translateY(0);

        }


        /* =========================
           FOOTER
           ========================= */

        .login-footer {

            text-align: center;

            margin-top: 25px;

            padding-top: 20px;

            border-top: 1px solid rgba(255, 255, 255, 0.07);

            color: #64748b;

            font-size: 0.72rem;

        }


        /* =========================
           RESPONSIVE
           ========================= */

        @media (max-width: 480px) {

            body {

                padding: 15px;

            }


            .login-box {

                padding: 35px 24px;

                border-radius: 16px;

            }


            .login-box h2 {

                font-size: 1.45rem;

            }

        }

    </style>

</head>


<body>


    <div class="login-box">


        <!-- ICON -->

        <div class="login-icon">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="30"
                height="30"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            >

                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>

                <circle cx="12" cy="13" r="4"/>

            </svg>

        </div>


        <!-- TITLE -->

        <h2>
            RENTAL <span>KAMERA</span>
        </h2>


        <p class="login-subtitle">
            Login
        </p>


        <!-- ERROR -->

        <?php

        if (isset($_GET['pesan'])) {

            if ($_GET['pesan'] == "gagal") {

        ?>

                <div class="alert-error">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="17"
                        height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <circle cx="12" cy="12" r="10"></circle>

                        <line x1="12" y1="8" x2="12" y2="12"></line>

                        <line x1="12" y1="16" x2="12.01" y2="16"></line>

                    </svg>

                    Username atau password salah!

                </div>

        <?php

            }

        }

        ?>


        <!-- FORM -->

        <form
            action="login_validasi.php"
            method="POST"
        >


            <!-- USERNAME -->

            <div class="input-group">

                <input
                    type="text"
                    name="username"
                    id="username"
                    required
                    autocomplete="username"
                >

                <label for="username">
                    Username
                </label>

            </div>


            <!-- PASSWORD -->

            <div class="input-group">

                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    autocomplete="current-password"
                >

                <label for="password">
                    Password
                </label>

            </div>


            <!-- BUTTON -->

            <button
                type="submit"
                name="login"
                class="btn-submit"
            >

                MASUK

            </button>


        </form>


        <!-- FOOTER -->

        <div class="login-footer">

            Sistem Rental Kamera &copy; <?= date('Y'); ?>

        </div>


    </div>


</body>

</html>

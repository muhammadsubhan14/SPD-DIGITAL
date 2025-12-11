{{-- 
    Login Page - SPD Digital
    Mahkamah Agung RI
--}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPD Digital</title>
    <style>
        /* ========================================
           CSS VARIABLES
           ======================================== */
        :root {
            --color-primary: #116e27;
            --color-secondary: #ddaf30;
            --color-background: #f4f6f9;
            --color-card: #ffffff;
            --color-border: #dddddd;
            --color-text: #333333;
            --color-text-light: #666666;
            --color-link: #155724;
            
            --color-error-bg: #f8d7da;
            --color-error-text: #721c24;
            --color-error-border: #f5c6cb;
            
            --spacing-xs: 8px;
            --spacing-sm: 12px;
            --spacing-md: 20px;
            --spacing-lg: 40px;
            
            --radius-sm: 5px;
            --radius-md: 10px;
            
            --shadow-card: 0 4px 20px rgba(0, 0, 0, 0.1);
            
            --max-width-card: 380px;
            --logo-size: 60px;
        }

        /* ========================================
           BASE STYLES
           ======================================== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: var(--color-background);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--color-text);
            line-height: 1.6;
            padding: var(--spacing-md);
        }

        /* ========================================
           CARD CONTAINER
           ======================================== */
        .card {
            background: var(--color-card);
            padding: var(--spacing-lg);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            width: 100%;
            max-width: var(--max-width-card);
        }

        /* ========================================
           HEADER
           ======================================== */
        .header {
            text-align: center;
            margin-bottom: var(--spacing-lg);
        }
        
        .header__logo {
            display: block;
            margin: 0 auto var(--spacing-md);
            max-width: var(--logo-size);
            height: auto;
        }
        
        .header__title {
            color: var(--color-primary);
            font-size: 1.8em;
            margin: 0;
            letter-spacing: 1px;
        }

        /* ========================================
           FORM
           ======================================== */
        .form {
            margin-bottom: var(--spacing-md);
        }
        
        .form__input {
            width: 100%;
            padding: var(--spacing-sm);
            margin: var(--spacing-xs) 0;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            font-size: 1em;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .form__input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(17, 110, 39, 0.1);
        }
        
        .form__input::placeholder {
            color: #999999;
        }
        
        .form__button {
            width: 100%;
            padding: var(--spacing-sm);
            margin: var(--spacing-xs) 0;
            background: var(--color-primary);
            color: white;
            font-weight: bold;
            font-size: 1em;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        
        .form__button:hover {
            background: #0d5620;
            transform: translateY(-1px);
        }
        
        .form__button:active {
            transform: translateY(0);
        }
        
        .form__button:disabled {
            background: #cccccc;
            cursor: not-allowed;
            transform: none;
        }

        /* ========================================
           ALERT
           ======================================== */
        .alert {
            padding: 12px 15px;
            margin-top: var(--spacing-md);
            border-radius: var(--radius-sm);
            font-size: 0.95em;
        }
        
        .alert--error {
            background: var(--color-error-bg);
            color: var(--color-error-text);
            border: 1px solid var(--color-error-border);
        }

        /* ========================================
           FOOTER
           ======================================== */
        .footer {
            text-align: center;
            margin-top: var(--spacing-md);
            color: var(--color-text-light);
        }
        
        .footer__link {
            color: var(--color-link);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        
        .footer__link:hover {
            color: var(--color-primary);
            text-decoration: underline;
        }

        /* ========================================
           RESPONSIVE DESIGN
           ======================================== */
        
        /* Tablet and below */
        @media (max-width: 768px) {
            .card {
                padding: 30px 25px;
            }
            
            .header__title {
                font-size: 1.6em;
            }
        }
        
        /* Mobile */
        @media (max-width: 480px) {
            body {
                padding: var(--spacing-sm);
            }
            
            .card {
                padding: 25px var(--spacing-md);
            }
            
            .header__logo {
                max-width: 50px;
            }
            
            .header__title {
                font-size: 1.4em;
            }
            
            .form__input,
            .form__button {
                padding: 11px;
                font-size: 0.95em;
            }
            
            .alert {
                padding: 10px 12px;
                font-size: 0.9em;
            }
            
            .footer {
                font-size: 0.95em;
            }
        }
        
        /* Small mobile */
        @media (max-width: 375px) {
            .card {
                padding: var(--spacing-md) 15px;
            }
            
            .header__logo {
                max-width: 45px;
            }
            
            .header__title {
                font-size: 1.3em;
            }
            
            .form__input,
            .form__button {
                padding: 10px;
                font-size: 0.9em;
            }
            
            .footer {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        {{-- HEADER --}}
        <div class="header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/0f/Logo_Mahkamah_Agung_RI.png" 
                 alt="Logo Mahkamah Agung RI" 
                 class="header__logo">
            <h2 class="header__title">LOGIN</h2>
        </div>

        {{-- LOGIN FORM --}}
        <form method="POST" action="{{ route('login') }}" class="form">
            @csrf
            
            <input type="email" 
                   name="email" 
                   autocomplete="username" 
                   value="{{ old('email') }}" 
                   placeholder="Email" 
                   class="form__input"
                   required 
                   autofocus>
            
            <input type="password" 
                   name="password" 
                   autocomplete="current-password" 
                   placeholder="Password" 
                   class="form__input"
                   required>
            
            <button type="submit" class="form__button">
                LOGIN
            </button>
        </form>

        {{-- FOOTER --}}
        <div class="footer">
            <p>
                Don't have an account? 
                <a href="{{ route('register') }}" class="footer__link">Register here</a>
            </p>
        </div>

        {{-- ERROR MESSAGES --}}
        @if($errors->any())
            <div class="alert alert--error">
                {{ $errors->first() }}
            </div>
        @endif
    </div>
</body>
</html>
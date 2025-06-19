<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Login</title>
    <style>

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 40px;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            color: #333;
            margin: 0;
            font-size: 28px;
        }

        .login-header p {
            color: #666;
            margin-top: 10px;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #555;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #6772e5;
            outline: none;
            box-shadow: 0 0 0 2px rgba(103, 114, 229, 0.2);
        }

        .btn-login {
            background: #6772e5;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px 0;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #5469d4;
        }

        .error-message {
            background-color: #fff2f2;
            border-left: 4px solid #ff6b6b;
            color: #e74c3c;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 14px;
        }

        .company-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .company-logo span {
            font-size: 40px;
            color: #6772e5;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="company-logo">
            <span>Work Wave</span>
        </div>
        
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Please sign in to access your account</p>
        </div>
        
        @if(session('error'))
            <div class="error-message">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif
        
        <form method="post" action="{{ route('login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" name="login" class="btn-login">Sign In</button>
        </form>
        
        <div class="login-footer">
            
        </div>
    </div>
</body>
</html>
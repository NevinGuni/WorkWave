<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <style>
        .dashboard-container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        header {
            background: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            font-size: 14px;
        }

        .user-info a {
            color: #fff;
            margin-left: 10px;
            text-decoration: none;
            padding: 5px 10px;
            background: #555;
            border-radius: 3px;
        }

        .welcome-message {
            padding: 15px 20px;
            background-color: #d9edf7;
            border: 1px solid #bce8f1;
            color: #31708f;
            margin: 20px;
            border-radius: 4px;
        }

        .dashboard-content {
            padding: 20px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard-header h2 {
            margin: 0;
        }

        .profile-info {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Employee Dashboard</h1>
            <div class="user-info">
                Logged in as: {{ session('username') }} (Employee)
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </header>
        
        @if(isset($welcome_message))
            <div class="welcome-message">{{ $welcome_message }}</div>
        @endif
        
        <div class="dashboard-content">
            <div class="dashboard-header">
                <h2>Your Profile</h2>
                <a href="{{ route('chat') }}" class="btn">Open Company Chat</a>
            </div>
            
            @if($employee)
                <div class="profile-info">
                    <p><strong>Name:</strong> {{ $employee->first_name }} {{ $employee->last_name }}</p>
                    <p><strong>Email:</strong> {{ $employee->email }}</p>
                </div>
            @else
                <p>Employee profile information not found.</p>
            @endif
            
            <a href="{{ route('employee.edit.profile') }}" class="btn">Edit Profile</a>
        </div>
    </div>
</body>
</html>
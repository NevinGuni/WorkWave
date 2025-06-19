<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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

        .admin-menu {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .menu-item {
            display: block;
            padding: 15px 20px;
            background: #f5f5f5;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
            flex: 1;
            min-width: 200px;
            text-align: center;
        }

        .menu-item:hover {
            background: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Admin Dashboard</h1>
            <div class="user-info">
                Logged in as: {{ session('username') }} (Admin)
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </header>
        
        @if(isset($welcome_message))
            <div class="welcome-message">{{ $welcome_message }}</div>
        @endif
        
        <div class="dashboard-content">
            <h2>Administration Panel</h2>
            
            <div class="admin-menu">
    <a href="{{ route('admin.departments') }}" class="menu-item">Manage Departments</a>
    <a href="{{ route('admin.employees') }}" class="menu-item">Manage Employees</a>
    <a href="{{ route('admin.department.tree') }}" class="menu-item">Department Analysis</a>
    <a href="{{ route('chat') }}" class="menu-item">Company Chat</a>
</div>
        <div>
    </div>
</body>
</html>
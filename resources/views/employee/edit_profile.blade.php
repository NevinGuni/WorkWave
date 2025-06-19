<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .edit-profile-container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .page-header {
            background-color: #4a4a4a;
            color: white;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus, 
        .form-group textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .current-image {
            margin: 10px 0;
        }
        .current-image img {
            max-width: 100px;
            border-radius: 5px;
        }
        .readonly-field {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        .btn-submit {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .btn-submit:hover {
            background-color: #45a049;
        }
        .btn-cancel {
            background-color: #f1f3f5;
            color: #333;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }
        .btn-cancel:hover {
            background-color: #e9ecef;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .error-message {
            background-color: #f2dede;
            color: #a94442;
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .tab {
            padding: 10px 15px;
            cursor: pointer;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-bottom: none;
            margin-right: 5px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        .tab.active {
            background-color: white;
            border-bottom: 1px solid white;
            margin-bottom: -1px;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="edit-profile-container">
        <div class="page-header">
            <h1>Edit Your Profile</h1>
        </div>
        
        @if(session('error'))
            <div class="message error-message">
                {{ session('error') }}
            </div>
        @endif

        <div class="tabs">
            <div class="tab active" onclick="showTab('profile')">Profile Information</div>
            <div class="tab" onclick="showTab('password')">Change Password</div>
        </div>

        <div id="profile-tab" class="tab-content active">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Profile Picture</label>
                    @if(!empty($employee->profile_picture))
                        <div class="current-image">
                            <p>Current image:</p>
                            <img src="{{ asset($employee->profile_picture) }}" alt="Profile Picture">
                        </div>
                    @endif
                    <input type="file" name="profile_picture" accept="image/*">
                </div>

                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="{{ $employee->first_name }}" required>
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="{{ $employee->last_name }}" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $employee->email }}" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" value="{{ $employee->phone }}">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address">{{ $employee->address }}</textarea>
                </div>

                <div class="form-group">
                    <label>Position</label>
                    <input type="text" value="{{ $employee->position }}" class="readonly-field" readonly>
                </div>

                <button type="submit" class="btn-submit">Update Profile</button>
                <a href="{{ route('employee.dashboard') }}" class="btn-cancel" style="display:block; text-align:center; text-decoration:none;">Cancel</a>
            </form>
        </div>

        <div id="password-tab" class="tab-content">
            <form method="post">
                @csrf
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" required minlength="8">
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" required minlength="8">
                </div>

                <button type="submit" name="change_password" value="1" class="btn-submit">Update Password</button>
                <a href="{{ route('employee.dashboard') }}" class="btn-cancel" style="display:block; text-align:center; text-decoration:none;">Cancel</a>
            </form>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            document.getElementById(tabName + '-tab').classList.add('active');
            
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>
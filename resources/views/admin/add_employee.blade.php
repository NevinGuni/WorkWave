<!DOCTYPE html>
<html>
<head>
    <title>Add New Employee</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .add-employee-container {
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
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus, 
        .form-group select:focus, 
        .form-group textarea:focus {
            border-color: #4CAF50;
            outline: none;
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
    </style>
</head>
<body>
    <div class="add-employee-container">
        <div class="page-header">
            <h1>Add New Employee</h1>
        </div>
        
        @if(session('error'))
            <div class="message error-message">
                {{ session('error') }}
            </div>
        @endif

        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" accept="image/*">
            </div>

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone">
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address"></textarea>
            </div>

            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position">
            </div>

            <div class="form-group">
                <label>Department</label>
                <select name="department_id" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->department_id }}">
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-submit">Add Employee</button>
            <a href="{{ route('admin.employees') }}" class="btn-cancel" style="display:block; text-align:center; text-decoration:none;">Cancel</a>
        </form>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Department</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .edit-department-container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .page-header {
            position: relative;
            background-color: #4a4a4a;
            color: white;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        .back-btn {
            position: absolute;
            left: 15px;
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        .back-btn:hover {
            color: #4CAF50;
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
    <div class="edit-department-container">
        <div class="page-header">
            <a href="{{ route('admin.departments') }}" class="back-btn">← Back</a>
            <h1>Edit Department</h1>
        </div>
        
        @if(session('error'))
            <div class="message error-message">
                {{ session('error') }}
            </div>
        @endif

        <form method="post">
            @csrf
            <div class="form-group">
                <label>Department Name</label>
                <input type="text" name="name" value="{{ $department->name }}" required>
            </div>
            <div class="form-group">
                <label>Parent Department (Optional)</label>
                <select name="parent_id">
                    <option value="">None</option>
                    @foreach($otherDepartments as $dept)
                        <option value="{{ $dept->department_id }}" 
                            {{ $dept->department_id == $department->parent_id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Description (Optional)</label>
                <textarea name="description">{{ $department->description }}</textarea>
            </div>
            <button type="submit" class="btn-submit">Update Department</button>
            <a href="{{ route('admin.departments') }}" class="btn-cancel" style="display:block; text-align:center; text-decoration:none;">Cancel</a>
        </form>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Departments</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .departments-container {
            max-width: 900px;
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
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .back-btn {
            position: absolute;
            left: 30px;
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }
        .back-btn:hover {
            color: #4CAF50;
        }
        .add-department-form {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
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
        .btn-add {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-add:hover {
            background-color: #45a049;
        }
        .departments-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
        }
        .departments-table th {
            background-color: #f1f3f5;
            color: #333;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #e9ecef;
        }
        .departments-table td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        .action-links a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }
        .action-links a:hover {
            color: #0056b3;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error-message {
            background-color: #f2dede;
            color: #a94442;
        }
        .tree-view-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="departments-container">
        <div class="page-header">
            <a href="{{ route('admin.dashboard') }}" class="back-btn">← Back to Dashboard</a>
            <h1>Manage Departments</h1>
        </div>
        
        @if(session('message'))
            <div class="message success-message">
                {{ session('message') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="message error-message">
                {{ session('error') }}
            </div>
        @endif

        <div class="add-department-form">
            <h2>Add New Department</h2>
            <form method="post" action="{{ route('admin.departments.add') }}">
                @csrf
                <div class="form-group">
                    <label>Department Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Parent Department (Optional)</label>
                    <select name="parent_id">
                        <option value="">None</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->department_id }}">
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Description (Optional)</label>
                    <textarea name="description"></textarea>
                </div>
                <button type="submit" class="btn-add">Add Department</button>
            </form>
        </div>

        <h2>Department Structure</h2>
        <div class="tree-view-container">
            <table class="departments-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Parent Department</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $dept)
                    <tr>
                        <td>{{ $dept->department_id }}</td>
                        <td>
                            @if($dept->parent_id)
                                &nbsp;&nbsp;&nbsp;&nbsp;└─ 
                            @endif
                            {{ $dept->name }}
                        </td>
                        <td>{{ $dept->parent ? $dept->parent->name : 'None' }}</td>
                        <td>{{ $dept->description ?: 'N/A' }}</td>
                        <td class="action-links">
                            <a href="{{ route('admin.departments.edit', $dept->department_id) }}">Edit</a>
                            <a href="{{ route('admin.departments.delete', $dept->department_id) }}" 
                               onclick="return confirm('Are you sure you want to delete this department?');">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
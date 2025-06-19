<!DOCTYPE html>
<html>
<head>
    <title>Batch Process Employees</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #4a4a4a;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            padding: 15px;
            position: relative;
        }
        .back-btn {
            position: absolute;
            left: 15px;
            color: white;
            text-decoration: none;
        }
        .back-btn:hover {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.employees') }}" class="back-btn">← Back to Employees</a>
                <h1 class="text-center mb-0">Batch Process Employees</h1>
            </div>
            
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form method="post" action="{{ route('admin.employees.batch') }}">
                    @csrf
                    <div class="form-group">
                        <label>Select Action:</label>
                        <select name="action" class="form-control" id="action-select">
                            <option value="">Select an action</option>
                            <option value="delete">Delete Selected Employees</option>
                            <option value="change_department">Change Department</option>
                        </select>
                    </div>
                    
                    <div class="form-group department-select" style="display:none;">
                        <label>Select Department:</label>
                        <select name="department_id" class="form-control">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->department_id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Select Employees:</label>
                        <div class="employee-list p-3 border rounded" style="max-height: 400px; overflow-y: auto;">
                            @foreach(App\Models\Employee::with('department')->get() as $employee)
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" name="employee_ids[]" value="{{ $employee->employee_id }}" id="employee-{{ $employee->employee_id }}">
                                    <label class="form-check-label" for="employee-{{ $employee->employee_id }}">
                                        {{ $employee->first_name }} {{ $employee->last_name }} - 
                                        {{ $employee->email }} 
                                        ({{ $employee->department ? $employee->department->name : 'Unassigned' }})
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Process</button>
                        <a href="{{ route('admin.employees') }}" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#action-select').change(function() {
                if ($(this).val() === 'change_department') {
                    $('.department-select').show();
                } else {
                    $('.department-select').hide();
                }
            });
        });
    </script>
</body>
</html>
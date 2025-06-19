<!DOCTYPE html>
<html>
<head>
    <title>Manage Employees</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
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
        .profile-thumb {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .action-btn {
            margin-right: 5px;
        }
        .department-filter {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.dashboard') }}" class="back-btn">← Back to Dashboard</a>
                <h1 class="text-center mb-0">Manage Employees</h1>
            </div>
            
            <div class="card-body">
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <a href="{{ route('admin.employees.add') }}" class="btn btn-success">Add New Employee</a>
                    <a href="{{ route('admin.employees.batch') }}" class="btn btn-primary ml-2">Batch Operations</a>
                </div>
                
                <div class="department-filter">
                    <div class="form-group">
                        <label for="department-select">Filter by Department:</label>
                        <select id="department-select" class="form-control" style="width: 300px;">
                            <option value="">All Departments</option>
                            @foreach(App\Models\Department::all() as $dept)
                                <option value="{{ $dept->department_id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table id="employees-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    
    <script>
        $(document).ready(function() {
            let table = $('#employees-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.employees.data') }}",
                    data: function(d) {
                        d.department_id = $('#department-select').val();
                    }
                },
                columns: [
                    { 
                        data: 'profile', 
                        name: 'profile',
                        searchable: false,
                        orderable: false,
                        render: function(data) {
                            return '<img src="' + data + '" class="profile-thumb">';
                        }
                    },
                    { data: 'employee_id', name: 'employee_id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'department', name: 'department' },
                    { data: 'position', name: 'position' },
                    { 
                        data: 'actions', 
                        name: 'actions',
                        searchable: false,
                        orderable: false
                    }
                ],
                pageLength: 10
            });
            
            $('#department-select').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
</body>
</html>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        $welcomeMessage = session('welcome_message');
        session()->forget('welcome_message');
        
        return view('admin.dashboard', [
            'welcome_message' => $welcomeMessage
        ]);
    }
    
    public function manageDepartments()
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        $departments = Department::with('parent')
            ->orderByRaw('parent_id IS NULL DESC, parent_id, name')
            ->get();
            
        return view('admin.manage_departments', [
            'departments' => $departments
        ]);
    }

    public function addDepartment(Request $request)
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        if ($request->isMethod('post')) {
            $name = $request->input('name');
            $parentId = $request->input('parent_id') ? $request->input('parent_id') : null;
            $description = $request->input('description') ? $request->input('description') : null;

            Department::create([
                'name' => $name,
                'parent_id' => $parentId,
                'description' => $description
            ]);

            return redirect()->route('admin.departments')
                ->with('message', 'Department added successfully!');
        }
    }

    public function deleteDepartment($id)
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        try {
            $department = Department::findOrFail($id);
            $department->delete();
            
            return redirect()->route('admin.departments')
                ->with('message', 'Department deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.departments')
                ->with('error', 'Failed to delete department: ' . $e->getMessage());
        }
    }

    public function editDepartment(Request $request, $id)
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        $department = Department::findOrFail($id);
        $otherDepartments = Department::where('department_id', '!=', $id)->get();
        
        if ($request->isMethod('post')) {
            $name = $request->input('name');
            $parentId = $request->input('parent_id') ? $request->input('parent_id') : null;
            $description = $request->input('description') ? $request->input('description') : null;

            $department->update([
                'name' => $name,
                'parent_id' => $parentId,
                'description' => $description
            ]);

            return redirect()->route('admin.departments')
                ->with('message', 'Department updated successfully!');
        }
        
        return view('admin.edit_department', [
            'department' => $department,
            'otherDepartments' => $otherDepartments
        ]);
    }
    
    // Employee Management Methods
    
    public function manageEmployees()
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        $employees = Employee::with('department')->get();
        
        return view('admin.manage_employees', [
            'employees' => $employees
        ]);
    }
    
    public function addEmployee(Request $request)
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        $departments = Department::all();
        
        if ($request->isMethod('post')) {
            $firstName = $request->input('first_name');
            $lastName = $request->input('last_name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $address = $request->input('address');
            $position = $request->input('position');
            $departmentId = $request->input('department_id');
            
            $profilePicture = 'uploads/profile_pictures/default.jpg'; // Default image
            
            if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
                $file = $request->file('profile_picture');
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = $file->getClientOriginalExtension();
                
                if (in_array(strtolower($extension), $allowed)) {
                    $filename = uniqid() . '.' . $extension;
                    $uploadPath = 'uploads/profile_pictures/' . $filename;
                    
                    if (!File::exists(public_path('uploads/profile_pictures'))) {
                        File::makeDirectory(public_path('uploads/profile_pictures'), 0777, true);
                    }
                    
                    $file->move(public_path('uploads/profile_pictures'), $filename);
                    $profilePicture = $uploadPath;
                }
            }
            
            $username = strtolower($firstName . '.' . $lastName);
            $password = 'Welcome123';
            $existingUser = User::where('username', $username)->first();
            
            if ($existingUser) {
                return redirect()->back()->with('error', "An employee with username '$username' already exists. Please try a different name.");
            }
            
            $user = User::create([
                'username' => $username,
                'password' => $password,
                'role' => 'employee'
            ]);
            
            Employee::create([
                'user_id' => $user->user_id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'position' => $position,
                'department_id' => $departmentId,
                'profile_picture' => $profilePicture
            ]);
            
            return redirect()->route('admin.employees')
                ->with('message', "Employee added successfully! Temporary password is 'Welcome123'");
        }
        
        return view('admin.add_employee', [
            'departments' => $departments
        ]);
    }
    
    public function editEmployee(Request $request, $id)
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        
        if ($request->isMethod('post')) {
            $firstName = $request->input('first_name');
            $lastName = $request->input('last_name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $address = $request->input('address');
            $position = $request->input('position');
            $departmentId = $request->input('department_id');
            
            $profilePicture = $employee->profile_picture; 
            
            if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
                $file = $request->file('profile_picture');
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = $file->getClientOriginalExtension();
                
                if (in_array(strtolower($extension), $allowed)) {
                    $filename = uniqid() . '.' . $extension;
                    $uploadPath = 'uploads/profile_pictures/' . $filename;
                    
                    if (!File::exists(public_path('uploads/profile_pictures'))) {
                        File::makeDirectory(public_path('uploads/profile_pictures'), 0777, true);
                    }
                    
                    $file->move(public_path('uploads/profile_pictures'), $filename);
                    
                    if ($employee->profile_picture != 'uploads/profile_pictures/default.jpg' && 
                        File::exists(public_path($employee->profile_picture))) {
                        File::delete(public_path($employee->profile_picture));
                    }
                    
                    $profilePicture = $uploadPath;
                }
            }
            
            //Updates Employee info
            $employee->update([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'position' => $position,
                'department_id' => $departmentId,
                'profile_picture' => $profilePicture
            ]);
            
            return redirect()->route('admin.employees')
                ->with('message', 'Employee updated successfully!');
        }
        
        return view('admin.edit_employee', [
            'employee' => $employee,
            'departments' => $departments
        ]);
    }
    
    public function deleteEmployee($id)
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        try {
            $employee = Employee::findOrFail($id);
            $userId = $employee->user_id;
            
            if ($employee->profile_picture != 'uploads/profile_pictures/default.jpg' && 
                File::exists(public_path($employee->profile_picture))) {
                File::delete(public_path($employee->profile_picture));
            }
            
            $employee->delete();
            $user = User::find($userId);
            if ($user) {
                $user->delete();
            }
            
            return redirect()->route('admin.employees')
                ->with('message', 'Employee deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.employees')
                ->with('error', 'Failed to delete employee: ' . $e->getMessage());
        }
    }
    
    public function departmentTreeReport()
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        $departments = Department::with('parent')->get();
        
        $total_employees = Employee::count();
        
        foreach ($departments as $department) {
            $department->employee_count = Employee::where('department_id', $department->department_id)->count();
            $department->children = collect();
        }
        
        foreach ($departments as $department) {
            if ($department->parent_id !== null) {
                $parent = $departments->firstWhere('department_id', $department->parent_id);
                if ($parent) {
                    $parent->children->push($department);
                }
            }
        }
        
        $topLevelCount = $departments->where('parent_id', null)->count();
        
        function findMaxDepth($departments, $currentDepth = 0) {
            $maxDepth = $currentDepth;
            foreach ($departments as $dept) {
                if ($dept->children && $dept->children->count() > 0) {
                    $childDepth = findMaxDepth($dept->children, $currentDepth + 1);
                    $maxDepth = max($maxDepth, $childDepth);
                }
            }
            return $maxDepth;
        }
        
        $maxDepth = 0;
        $topLevelDepartments = $departments->where('parent_id', null);
        if ($topLevelDepartments->count() > 0) {
            $maxDepth = findMaxDepth($topLevelDepartments);
        }
        
        return view('admin.department_tree_report', [
            'departments' => $departments,
            'topLevelDepartments' => $topLevelDepartments,
            'total_employees' => $total_employees,
            'topLevelCount' => $topLevelCount,
            'maxDepth' => $maxDepth + 1 
        ]);
    }
    
    public function getEmployeesData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $search = $request->get('search', ['value' => '']);
        $order = $request->get('order', []);
        $columns = $request->get('columns', []);
        
        $departmentId = $request->get('department_id');
        
        $query = Employee::with('department')
            ->select('employees.*');
        
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }
        
        if (!empty($search['value'])) {
            $searchTerm = '%' . $search['value'] . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'like', $searchTerm)
                  ->orWhere('last_name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('phone', 'like', $searchTerm)
                  ->orWhere('position', 'like', $searchTerm);
            });
        }
        
        $totalRecords = $query->count();

        if (!empty($order)) {
            $columnIndex = $order[0]['column'];
            $columnName = $columns[$columnIndex]['data'];
            $columnDir = $order[0]['dir'];
            
            $columnMap = [
                'employee_id' => 'employee_id',
                'name' => 'first_name',
                'email' => 'email',
                'phone' => 'phone',
                'department' => 'department_id',
                'position' => 'position'
            ];
            
            if (isset($columnMap[$columnName])) {
                $query->orderBy($columnMap[$columnName], $columnDir);
            }
        }
        
        // Pagination
        $records = $query->skip($start)
            ->take($length)
            ->get();
        
        $formattedRecords = [];
        
        foreach ($records as $record) {
            $formattedRecords[] = [
                'DT_RowId' => 'row_' . $record->employee_id,
                'employee_id' => $record->employee_id,
                'profile' => asset($record->profile_picture ?: 'uploads/profile_pictures/default.jpg'),
                'name' => $record->first_name . ' ' . $record->last_name,
                'email' => $record->email,
                'phone' => $record->phone ?: 'N/A',
                'department' => $record->department ? $record->department->name : 'Unassigned',
                'position' => $record->position ?: 'N/A',
                'actions' => '<a href="' . route('admin.employees.edit', $record->employee_id) . '">Edit</a> | 
                             <a href="' . route('admin.employees.delete', $record->employee_id) . '" 
                                onclick="return confirm(\'Are you sure you want to delete this employee?\');">Delete</a>'
            ];
        }
        
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $formattedRecords
        ]);
    }

    public function getDepartmentEmployees(Request $request)
    {
        $departmentId = $request->get('department_id');
        
        if (!$departmentId) {
            return $this->getEmployeesData($request);
        }
        
        return $this->getEmployeesData($request);
    }
    
    public function batchProcess(Request $request)
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect()->route('login');
        }
        
        if ($request->isMethod('post')) {
            $action = $request->input('action');
            $employeeIds = $request->input('employee_ids', []);
            
            if (empty($employeeIds)) {
                return redirect()->back()->with('error', 'No employees selected.');
            }
            
            switch ($action) {
                case 'delete':              
                    foreach ($employeeIds as $id) {
                        $employee = Employee::find($id);
                        if ($employee) {
                            $userId = $employee->user_id;
                            
                            if ($employee->profile_picture != 'uploads/profile_pictures/default.jpg' && 
                                File::exists(public_path($employee->profile_picture))) {
                                File::delete(public_path($employee->profile_picture));
                            }
                            
                            $employee->delete();
                            
                            $user = User::find($userId);
                            if ($user) {
                                $user->delete();
                            }
                        }
                    }
                    return redirect()->route('admin.employees')->with('message', count($employeeIds) . ' employees deleted successfully.');
                    
                case 'change_department':
                    $departmentId = $request->input('department_id');
                    if (!$departmentId) {
                        return redirect()->back()->with('error', 'No department selected.');
                    }
                    
                    Employee::whereIn('employee_id', $employeeIds)->update(['department_id' => $departmentId]);
                    return redirect()->route('admin.employees')->with('message', count($employeeIds) . ' employees updated successfully.');
                    
                default:
                    return redirect()->back()->with('error', 'Invalid action selected.');
            }
        }
        
        $departments = Department::all();
        return view('admin.batch_process', ['departments' => $departments]);
    }
}
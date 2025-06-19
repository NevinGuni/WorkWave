<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        if (!session('user_id') || session('role') !== 'employee') {
            return redirect()->route('login');
        }
        
        $welcomeMessage = session('welcome_message');
        session()->forget('welcome_message');
        
        $employee = Employee::where('user_id', session('user_id'))->first();
        
        return view('employee.dashboard', [
            'welcome_message' => $welcomeMessage,
            'employee' => $employee
        ]);
    }
    
    public function editProfile(Request $request)
    {
        if (!session('user_id') || session('role') !== 'employee') {
            return redirect()->route('login');
        }
        
        $userId = session('user_id');
        $employee = Employee::where('user_id', $userId)->first();
        
        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile not found.');
        }
        
        if ($request->isMethod('post')) {
            if ($request->has('change_password')) {
                $currentPassword = $request->input('current_password');
                $newPassword = $request->input('new_password');
                $confirmPassword = $request->input('confirm_password');
                
        $user = User::where('user_id', $userId)->first();

         if (!password_verify($currentPassword, $user->password)) {
         return redirect()->back()
        ->with('error', 'Current password is incorrect.');
               } 
        $user->update([
        'password' => password_hash($newPassword, PASSWORD_DEFAULT)
                ]);

                if ($newPassword !== $confirmPassword) {
                    return redirect()->back()
                        ->with('error', 'New passwords do not match.');
                }
                
                if (strlen($newPassword) < 8) {
                    return redirect()->back()
                        ->with('error', 'New password must be at least 8 characters long.');
                }
                
                $user->update([
                    'password' => $newPassword
                ]);
                
                return redirect()->route('employee.dashboard')
                    ->with('message', 'Password updated successfully!');
            } else {
                $firstName = $request->input('first_name');
                $lastName = $request->input('last_name');
                $email = $request->input('email');
                $phone = $request->input('phone');
                $address = $request->input('address');
                             
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
                        
                        if (!empty($employee->profile_picture) && 
                            $employee->profile_picture != 'uploads/profile_pictures/default.jpg' && 
                            File::exists(public_path($employee->profile_picture))) {
                            File::delete(public_path($employee->profile_picture));
                        }
                        
                        $profilePicture = $uploadPath;
                    }
                }
                
                $employee->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'profile_picture' => $profilePicture
                ]);
                
                return redirect()->route('employee.dashboard')
                    ->with('message', 'Profile updated successfully!');
            }
        }
        
        return view('employee.edit_profile', [
            'employee' => $employee
        ]);
    }
}
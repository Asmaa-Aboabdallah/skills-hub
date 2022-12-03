<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{
   public function index()
   {
    $superAdminRole = Role::where('name', 'superadmin')->first();
    $adminRole = Role::where('name', 'admin')->first();


    $data['admins'] = User::whereIn('role_id',[$superAdminRole->id , $adminRole->id])
    ->orderBy('id', 'DESC')->paginate(10);

   return view('admin.admins.index')->with($data);
   }

   public function create()
   {
    $data['roles'] = Role::select('id', 'name')
    ->whereIn('name', ['superadmin', 'admin'])->get();
     return view('admin.admins.create')->with($data);
   }

   public function store(Request $request)
   {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'password' => 'required|string|min:5|max:25|confirmed',
      'role_id' => 'required|exists:roles,id',
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role_id'=> $request->role_id,
    ]);

    // to send email verification after register 
    event(new Registered($user));

    return redirect(url("dashboard/admins"));

   }

   public function promote($id)
   {
      $admin = User::findOrFail($id);
      $admin->update([
        'role_id' => Role::select('id')->where('name' , 'superadmin')->first()->id,
      ]);
      return back();
   }

   public function demote($id)
   {
      $superAdmin = User::findOrFail($id);
      $superAdmin->update([
        'role_id' => Role::select('id')->where('name' , 'admin')->first()->id,
      ]);

      return back();
   }


   public function update(Request $request)
   {
      $request->validate([
        'id' => 'required|exists:users,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:5|max:25',
      ]);

      // dd($request->all());

      $user = User::findOrFail($request->id)->update([
         'name' => $request->name,
         'email' => $request->email,
         'password' => Hash::make($request->password),
      ]);


      $request->session()->flash('msg', 'User Updated Successfuly');
      return back();
      
   }

   public function delete( $id , Request $request) 
   {
      try {
        $admin = User::findOrFail($id);
         $admin->delete();
         $msg = "User Deleted Successfuly";
      } catch (Exception $e) {
         $msg = "Can't Delete this user";
      }
      $request->session()->flash('msg', $msg);
      
      return back();
   }
}

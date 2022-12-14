<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // TASK: turn this SQL query into Eloquent
        // select * from users
        //   where email_verified_at is not null
        //   order by created_at desc
        //   limit 3
       
        // $users = User::all(); // replace this with Eloquent statement
         $users = User::where('email_verified', not null)
            ->orderByDesc('created_at')
            ->limit(3);

        return view('users.index', compact('users'));
    }

    public function show($userId)
    {
        $user = User::findOfFail($userId); // TASK: find user by $userId or show "404 not found" page

        return view('users.show', compact('user'));
    }

    public function check_create($name, $email)
    {
        // TASK: find a user by $name and $email
        //   if not found, create a user with $name, $email and random password
        $user = User::firstOrCreate(
            ['name' => '$name'],
            ['email' => '$email'],
            ['password' => 'random()']
        );

        return view('users.show', compact('user'));
    }

    public function check_update($name, $email)
    {
        // TASK: find a user by $name and update it with $email
        //   if not found, create a user with $name, $email and random password
        $user = User::firstOrCreate(
            ['name' => '$name']->where('email'),
            ['email' => '$email'],
            ['password' => 'random()']
        );// updated or created user

        return view('users.show', compact('user'));
    }

    public function destroy(Request $request)
    {
        // TASK: delete multiple users by their IDs
        // SQL: delete from users where id in ($request->users)
        // $request->users is an array of IDs, ex. [1, 2, 3]

        // Insert Eloquent statement here
        $users = User::destroy(1, 2, 3);

        return redirect('/')->with('success', 'Users deleted');
    }

    public function only_active()
    {
        // TASK: That "active()" doesn't exist at the moment.
        //   Create this scope to filter "where email_verified_at is not null"
        $users = User::active()->get()->where('email_verified_at', NOT NULL);

        return view('users.index', compact('users'));
    }

}

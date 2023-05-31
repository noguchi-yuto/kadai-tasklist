<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
        public function index()     
    {
        // ユーザ一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10);

        // ユーザ一覧ビューでそれを表示
    }
    
    public function show($id)
    {
        $user=User::findOrFail($id);
        $user->loadRelationshipCounts();
        $tasks=$user->tasks()->orderBy('created_at','desc')->paginate(10);
        return view('users.show',[
            'user'=>$user,
            'tasks'=>$tasks,
            ]);
    }   
}

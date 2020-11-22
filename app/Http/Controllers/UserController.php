<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // 追加

class UserController extends Controller
{
    public function index()
    {
        // タスク一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10);

        // タスク一覧ビューでそれを表示
        return view('tasks.index', [
            'users' => $users,
        ]);
    }
    
     public function show($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // ユーザ詳細ビューでそれを表示
        return view('tasks.show', [
            'user' => $user,
        ]);
    }
}

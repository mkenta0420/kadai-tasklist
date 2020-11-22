<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Task;

class TasksController extends Controller
{
  
    // getでtask/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(15);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            return view('tasks.index', $data);
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }

    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create',[
            'task' => $task,
            ]);
    }

    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        
        //バリテーション
        $request->validate([
            //'user_id' => 'required|max:255',   // 追加
            'content' => 'required|max:255',
            'status' => 'required|max:10',
            ]);
         // タスクを作成
        $task = new Task;
        $task->user_id = Auth::user()->id;   // 追加
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // getでmessages/（任意のid）にアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        // タスク詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    // getでtasks/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit(Request $request,$id)
    {
        
         // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        // タスク編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    // putまたはpatchでtask/（任意のid）にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        $request->validate([
         //   'user_id' => 'required|max:255',   // 追加
            'content' => 'required|max:255',
            'status' => 'required|max:10',
            ]);
         // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // タスクを更新
       // $task->user_id = $request->user_id;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        
       
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // deleteでtask/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを削除
         // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}

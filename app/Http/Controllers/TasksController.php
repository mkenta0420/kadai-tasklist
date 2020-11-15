<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
  
    // getでmessages/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        //タスク一覧取得
        $tasks = Task::all();
        
        //タスク一覧ビューでそれを表示
        return view('tasks.index', [
            'tasks' => $tasks,
            ]);
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
            'content' => 'required|max:255',
            'status' => 'required|max:10',
            ]);
         // タスクを作成
        $task = new Task;
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
            'content' => 'required|max:255',
            'status' => 'required|max:10',
            ]);
         // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // タスクを更新
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
        $task->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}

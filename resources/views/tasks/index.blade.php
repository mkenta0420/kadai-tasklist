@extends('layouts.app')

@section('content')

        <h1>タスク一覧</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>タスク</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                 {{-- メッセージ詳細ページへのリンク --}}
                     <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                     <td>{{ $task->content }}</td>
                     <td>{{ $task->status }}</td>
                </tr>
                @endforeach
            </tbody>
            <div>
            {{-- タスク作成ページへのリンク --}}
            {!! link_to_route('tasks.create', '新規タスク登録', [], ['class' => 'btn btn-primary']) !!}
            </div>
           
        </table>


    
  

@endsection
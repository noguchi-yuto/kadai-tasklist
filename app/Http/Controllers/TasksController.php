<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[];
        if(\Auth::check()){
            $user = \Auth::user();
            $tasks=$user->tasks()->orderBy('created_at','desc')->paginate(10);
            $data=[
                'user' => $user,
                'tasks' => $tasks,
                ];
        }
        // タスク一覧ビューでそれを表示
        return view('dashboard',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task;
        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(\Auth::id()===$task->user_id){
            //バリデーション
            $request->validate([
                'content' => 'required',
                'status' => 'required|max:10',
                ]);
            // タスクを作成
            $request->user()->tasks()->create([
                'content'=>$request->content,
                'status'=>$request->status,
            ]);            
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        // タスク詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // タスク編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // idの値でタスクを検索して取得
        
        if(\Auth::id()===$task->user_id){
            $task = Task::findOrFail($id);
            //バリデーション
            $request->validate([
                'status' => 'required|max:10',
                'content' => 'required',
            ]);
            // タスクを更新
            $task->content = $request->content;
            $task->status = $request->status;
            $task->save();
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // idの値でタスクを検索して取得
        if(\Auth::id()===$task->user_id){
            $task = Task::findOrFail($id);
            // タスクを削除
            if(\Auth::id()===$task->user_id){
                $task->delete();
            }            
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }
}

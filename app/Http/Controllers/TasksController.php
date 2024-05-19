<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Get tasks
     *
     * @return JSON
     */
    public function get(){
        $tasks = Task::where('user_id', Auth::user()->id)->orderBy('created_at');
        return response()->json(
            [
                'tasks' => $tasks->get(),
                'userTotalTasks' => $tasks->count()
            ]
        );
    }

    /**
     * Create task to database and return it as a json response
     *
     * @param Request $request
     * @return JSON
     */
    public function create(Request $request){
        $id = (rand(9,999999999)+time()) * rand(0,999);
        Task::create([
            'id'      => $id,
            'user_id' => Auth::user()->id,
            'title'   => $request['title'],
            'body'    => $request['body'],
            'observation'    => $request['observation'],
            'status'    => $request['status'],
        ]);
        return response()->json(Task::find($id));
    }

    /**
     * Delete Task
     *
     * @param Request $request
     * @return JSON
     */
    public function update(Request $request, $id){
        $this->validate($request, [
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'observation' => 'nullable|string',
            'status'      => 'required|string',
        ]);

        $task = Task::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if (!$task) {
            return response()->json(['error' => 'Task not found or access denied'], 404);
        }

        $task->update([
            'title'       => $request['title'],
            'body'        => $request['body'],
            'observation' => $request['observation'],
            'status'      => $request['status'],
        ]);

        return response()->json($task);
    }

    /**
     * Delete Task
     *
     * @param Request $request
     * @return JSON
     */
    public function delete(Request $request, $id){
        return response()->json(Task::find($id)->delete());
    }
}

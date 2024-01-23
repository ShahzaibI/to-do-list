<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $todos = Todo::where('status', 1)->orwhere('status', 2)->where('user_id', auth()->user()->id)->get();

      return view('todolist',compact('todos'));
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required',
            'datetime' => 'required',
        ]);
        $data = new Todo;
        $data->user_id = auth()->user()->id;
        $data->task = $request->task;
        $data->datetime = $request->datetime;
        $data->save();
        return redirect(route('todolist.index'))->with('message','The Task was successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todos = Todo::where('status', 1)->orwhere('status', 2)->get();
        $todoone = Todo::find($id);
        return view('todolist',compact('todoone','todos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'task' => 'required',
            'datetime' => 'required',
        ]);
        $data = Todo::find($id);
        $data->task = $request->task;
        $data->datetime = $request->datetime;
        $data->update();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Todo::find($id);
        $data->status = 0;
        $data->update();
        return back();
    }
    public function completed($id)
    {
        $data = Todo::find($id);
        $data->status = 2;
        $data->update();
        return back();
    }
}

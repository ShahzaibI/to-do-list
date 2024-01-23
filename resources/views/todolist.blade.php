{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>To Do List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body> --}}
@extends('layouts.main')
@section('content')
    <div class='container'>
        <div class="card mt-4">
            <div class="card-header">
                <div class="col-md-12  text-center" style="margin: 10px;">
                    <h3>To Do List</h3>
                </div>
            </div>
            <div class="card-body">
        @isset($todoone)
        <form action="{{ route('todolist.update',$todoone->id) }}" method="POST">
            @csrf
            {{ method_field('put')}}
            <div class='row'>


                
                @if(count($errors->all()) > 0)
                <div class="alert alert-danger" role="alert">
                    <p><b>Required Fields Missing!</b></p>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="col-md-6 form-group ">
                    <label>Task</label>
                    <input class="form-control" type="text" name="task" value="{{ $todoone->task }}"  required>
                </div>
                <div class="col-md-4 form-group">
                    <label>Date & Time</label>
                    <input class="form-control" type="datetime-local" value="{{ $todoone->datetime }}" name="datetime" required>
                </div>
                <div class="col-md-2 form-group">
                    <label>Action</label>
                    <input class="form-control btn btn-success" type="submit" value="Update" required>
                </div>
                <div class="col-md-12 form-group">

                    <a href="{{ url('todolist') }}" class="btn btn-success" type="button" > <i class="fa fa-plus"></i></a>
                </div>
            </form>

            @else
            <form action="{{ route('todolist.store') }}" method="POST">

                @csrf
                <div class='row'>

 
                    @if(count($errors->all()) > 0)
                    <div class="alert alert-danger" role="alert">
                        <p><b>Required Fields Missing!</b></p>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="col-md-6 form-group">
                        <label>Task</label>
                        <input class="form-control" type="text" name="task" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Date & Time</label>
                        <input class="form-control" type="datetime-local" name="datetime" required>
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Action</label>
                        <input class="form-control btn btn-success" type="submit" value="Add" required>
                    </div>
                    

                </form>
                @endisset
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead style="background: #f7f7f7;">
                            <th>Sr No.</th>
                            <th>Task</th>
                            <th>Date & Time</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $sr = 1; ?>
                            @foreach($todos as $row)
                            @if($row->status == 2)
                             <tr style="background: lightgreen;">
                                <td>{{ $sr }}</td>
                                <td>{{ $row->task }}</td>
                                <td><?php echo date('d-m-y D H:i a',strtotime($row->datetime)) ?></td>
                                <td>
                                    Completed
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td>{{ $sr }}</td>
                                <td>{{ $row->task }}</td>
                                <td><?php echo date('d-m-y D H:i a',strtotime($row->datetime)) ?></td>
                                <td>
                                    <a class="btn btn-primary p-1 m-1" href="{{ route('todolist.edit',$row->id) }}" ><i class="fa fa-edit"></i></a>

                                    {!! Form::open(['method' => 'post', 'route' => ['todolist.completed', $row->id], 'style' => 'display:inline']) !!}
                                    {!! Form::button('<i class="fa fa-check"></i>', ['type' => 'submit', 'class' => 'btn btn-success p-1 m-1']) !!}
                                    {!! Form::close() !!}

                                    {!! Form::open(['method' => 'Delete','route' => ['todolist.destroy', $row->id],'style'=>'display:inline']) !!}
                                    {!! Form::button('<i class="fa fa-trash-o "></i>', ['type' => 'submit','class' => 'btn btn-danger p-1 m-1']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                             @endif
                            <?php $sr++; ?> 
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html> --}}

@extends('layouts.app')

@section('content')

    <!-- Bootstrapの定形コード -->
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/task/{{ $task->id }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                           <label for="task" class="col-sm-3 control-label">タスク</label>

                           <div class="col-sm-6">
                               <input type="text" name="name" id="task-name" value="{{ $task->name }}" class="form-control">
                           </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-plus"></i> タスク変更
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

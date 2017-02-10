@extends('admin.default.master')

@section('title','权限')

@section('menu','权限')
@section('page','权限列表')

@section('pageTitle','列表')

@section('css')


@endsection

@section('content')

    <!-- Table Striped -->
    <div class="block-area" id="tableStriped">
        <h3 class="block-title">权限列表</h3>
        <a href="{{route('permission.create')}}"><button class="btn-info">创建新权限</button></a>
        <div class="table-responsive overflow">
            <table class="tile table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>权限名</th>
                    <th>权限别名</th>
                    <th>描述</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->display_name}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <form action="/admin/permission/{{$item->id}}" method="post">
                                <button class="btn-primary"><a href="{{route('permission.edit',$item->id)}}">  <span class="icon">&#61952;</span> 修改</a></button>
                                <input type="hidden" name="_method" value="delete">
                                {!! csrf_field() !!}
                                <button class="btn-danger"><span class="icon">&#61918;</span> 删除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        {{ $permissions->appends(['sort' => 'created_at'])->links() }}
    </div>

@endsection

@section('js')
    {!! reminder()->message() !!}
@endsection

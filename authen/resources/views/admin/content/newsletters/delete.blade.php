@extends('admin.layouts.glance')
@section('title')
Xóa Newsletters
@endsection
@section('content')

    <h1> Xóa Newsletters {{ $newsletter->id . ' : ' . $newsletter->name }}</h1>

    <div class="row">
        <div class="form-three widget-shadow">
            <form name="page" action="{{ url('admin/newsletters/'.$newsletter->id.'/delete ') }}" method="post" class="form-horizontal">
                @csrf

                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
@endsection

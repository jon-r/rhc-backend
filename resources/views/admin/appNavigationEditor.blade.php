@extends('admin.layouts.admin')

@section('title', 'navigation settings')

@section('content')
<div class="row">
  <div class="col-md-6">
      {{ Form::model($links, ['route' => ['admin.site.navigation.save'], 'method' => 'put', 'class' => 'panel-group']) }}

      <div id="links_{{$location}}" data-sortable>
        @foreach ($links as $link)
        <formgroup class="panel panel-info" >
          <div class="panel-heading drag-handle">
            <a role="button" data-toggle="collapse" href="#collapse_{{$link->id}}" >
              <i class="fa fa-ellipsis-v fa-lg fa-fw"></i>
              <span class="panel-title" id="title_{{$link->id}}">
                {{$link->name}}
              </span>
            </a>
          </div>

          <div id="collapse_{{$link->id}}" class="panel-collapse collapse" >
            <div class="panel-body">
              {{ Form::hidden('id', $link->id)}}
              {{ Form::hidden('sort_order', $link->sort_order)}}

              {{ Form::label('name', 'Name') }}
              {{ Form::text('location', $link->name, [ 'class' => 'form-control', 'data-bind' => "#title_$link->id" ]) }}

              {{ Form::label('url', 'URL') }}
              {{ Form::text('location',$link->url, [ 'class' => 'form-control' ]) }}
            </div>
          </div>
        </formgroup>
        @endforeach
      </div>

      <formgroup class="panel panel-default" id="links_{{$location}}_template" >
        <div class="panel-heading">
          <a role="button" data-new-input="#links_{{$location}}">
            <i class="fa fa-plus fa-lg fa-fw"></i>
            <span class="panel-title" >
              Add new item
            </span>
          </a>
        </div>

        <div class="panel-collapse collapse" >
          <div class="panel-body">
              <input name="sort_order" type="hidden">

              <label for="name">Name</label>
              <input class="form-control" data-bind name="location" type="text">

              <label for="url">URL</label>
              <input class="form-control" name="location" type="text">
          </div>
        </div>

      </formgroup>

      {{ Form::close() }}
  </div>

</div>
@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/formHelpers.js')) }}
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/common.css'))}}
@endsection

@extends('admin.layouts.admin')

@section('title', 'navigation settings')

@section('content')
<div class="row">
  <div class="col-md-6">
      {{ Form::model($links, [
        'route' => ['admin.site.navigation.save'],
        'method' => 'put',
        'class' => 'panel-group',
        'data-parsley-validate' => true
        ]) }}

      <div id="links_{{$location}}" data-sortable>
        @for ($i = 0; $i < count($links); $i++)
        <div class="panel panel-info" >
          <div class="panel-heading drag-handle">
            <a role="button" data-toggle="collapse" href="#collapse_{{$i}}" >
              <i class="fa fa-ellipsis-v fa-lg fa-fw"></i>
              <span class="panel-title" id="title_{{$i}}">
                {{$links[$i]->name}}
              </span>
            </a>
          </div>

          <div id="collapse_{{$i}}" class="panel-collapse collapse" >
            <div class="panel-body">
              {{ Form::hidden("id$i", $links[$i]->id)}}
              {{ Form::hidden("sort_order$i", $links[$i]->sort_order)}}

              {{Form::label("name$i", 'Name') }}
              {{Form::text("name$i", $links[$i]->name, [
                'class' => 'form-control',
                'data-bind' => "title_$i"
                ]) }}

              {{ Form::label("location$i", 'URL') }}
              {{ Form::text("location$i", $links[$i]->url, [ 'class' => 'form-control' ]) }}
            </div>
          </div>
        </div>
        @endfor
      </div>

      <div class="panel panel-default" id="links_{{$location}}_template">
        <div class="panel-heading drag-handle">
          <a role="button" class="new-button" data-toggle="collapse" data-new-input="links_{{$location}}">
            <i class="fa fa-plus fa-lg fa-fw"></i>
            <span class="panel-title new-title" >
              New...
            </span>
          </a>
        </div>

        <div class="panel-collapse collapse new-panel" >
          <div class="panel-body">
              <input class="new-sort" name="sort_order" type="hidden">

              <label for="name">Name</label>
              <input class="form-control new-name" data-bind name="name" value="New" type="text">

              <label for="url">URL</label>
              <input class="form-control" name="location" value="/" type="text">
          </div>
        </div>

      </div>

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

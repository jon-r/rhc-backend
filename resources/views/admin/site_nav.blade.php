@extends('admin.layouts.admin')

@section('title', 'navigation settings')

@section('content')
<div class="row">
  <div class="col-md-6">
    @foreach ($navBars as $navBar)
      <form id="nav{{$loop->index}}" data-sortable>
        @foreach ($navBar as $nav)
        <fieldset id="{{$nav->location}}_{{$nav->id}}" class="form-inline"  >
          <div  class="input-group">
            <span class="input-group-addon drag-handle" >Text</span>
            <input type="text" class="form-control" placeholder="label" value="{{$nav->name}}">
          </div>
          <div id="{{$nav->location}}_{{$nav->id}}" class="input-group">
            <span class="input-group-addon drag-handle" >Link</span>
            <input type="text" class="form-control" placeholder="label" value="{{$nav->url}}">
          </div>
        </fieldset>
        @endforeach
      </form>
    @endforeach
  </div>

</div>
@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
    {{ Html::script(mix('assets/admin/js/sortableForms.js')) }}
@endsection

@section('styles')
    @parent
@endsection

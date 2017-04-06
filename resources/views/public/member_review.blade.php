<div class="row">
    {{ Form::label('name', trans('user.lbl-name'), ['class' => 'col-md-4 control-label']) }}
    {{ Form::label('name', $user->name, ['class' => 'col-md-8']) }}
</div>

 <div class="row">
    {{ Form::label('email', trans('user.lbl-email'), ['class' => 'col-md-4 control-label']) }}
    {{ Form::label('email', $user->email, ['class' => 'col-md-4']) }}
</div>

<div class="row">
    {{ Form::label('name', trans('user.lbl-birthday'), ['class' => 'col-md-4 control-label']) }}
    {{ Form::label('name', $user->birthday, ['class' => 'col-md-4']) }}
</div>
@php
    $position = '';
    if(!is_null($user->position)) {
         $position = $user->position->name;
    }
@endphp
<div class="row">
    {{ Form::label('position', trans('user.lbl-position'), ['class' => 'col-md-4 control-label']) }}
    {{ Form::label('name', $position , ['class' => 'col-md-4']) }}
</div>

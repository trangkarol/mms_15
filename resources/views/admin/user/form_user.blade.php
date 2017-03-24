 <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
      {{ Form::label('name', trans('user.lbl-name'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::text('name', isset($user->name) ? $user->name : old('name'), ['class' => 'form-control', 'id' => 'name', 'required' => true, 'autofocus' => true]) }}

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {{ Form::label('email', trans('user.lbl-email'), ['class' => 'col-md-4 control-label']) }}

    <div class="col-md-6">
        {{ Form::text('email', isset($user->email) ? $user->email : old('email'), ['class' => 'form-control',  'id' => 'email', 'required' => true]) }}

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
    {{ Form::label('birthday', trans('user.lbl-birthday'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::date('birthday', isset($user->birthday) ? $user->birthday : old('birthday'), ['class' => 'form-control', 'id' => 'birthday', 'required' => true]) }}
    </div>
</div>

<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
    {{ Form::label('role', trans('user.lbl-role'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{ Form::select('role', [config('setting.role.user') => 'User' , config('setting.role.admin') => 'Admin'], isset($user->role) ? $user->role : old('role'), ['class' => 'form-control', 'id' => 'role']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('position', trans('user.lbl-position'), ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        {{Form::select('position', $positions, isset($user->position_id) ? $user->position_id : old('position'), ['class' => 'form-control','id' => 'position']) }}
    </div>
</div>

@if(isset($user))
    <!-- skill -->
    @include('admin.user.skill')
    <!-- team -->
    <div class="panel panel-primary">
        <div class="panel panel-heading">
            {{ trans('project.lbl-team') }}
        </div>

        <div class="panel panel-body table-result">
            <div class="form-group">
                @foreach ($teams as $key => $team)
                    @if(!in_array($key, $arrTeam))
                        <div class="col-md-6">
                            {{ Form::checkbox('teams[]', $key, null, ['class' => 'team', 'id' => 'team']) }} {{ $team }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="panel panel-body" id="result-team">
            @include('admin.user.team')
        </div>
    </div>

@endif

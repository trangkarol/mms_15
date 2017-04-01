<div class="panel-heading">
    {{ trans('admin.lbl-search') }}
</div>
<!--     -->
<div class="panel-body">
    <div class="row">
        <div class="col-md-6">
            <label for="team" class="col-md-6">{{ trans('user.lbl-team') }}</label>
            <div class="col-md-6">
                {{ Form::select('team', $teams, null, ['class' => 'form-control', 'id' => 'team']) }}
            </div>
        </div>

         <div class="col-md-6">
            <label for="team" class="col-md-6">{{ trans('user.lbl-position') }}</label>
            <div class="col-md-6">
                {{ Form::select('team', $position, null, ['class' => 'form-control', 'id' => 'position']) }}
            </div>
        </div>
     </div>
     <!--  -->
     <div class="row margintop">
          <div class="col-md-6">
            <label for="team" class="col-md-6">{{ trans('user.lbl-position_team') }}</label>
            <div class="col-md-6">
                {{ Form::select('team', $positionTeams, null, ['class' => 'form-control', 'id' => 'positionTeams']) }}
            </div>
        </div>
    </div>
    <!--  -->
    <div class="row">
        <div class="col-md-3 col-md-offset-9">
            <button type="button" class="btn btn-primary" id="btn-search">{{ trans('admin.lbl-search') }}</button>
        </div>
    </div>
</div>

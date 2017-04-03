<div class="panel-heading">
    {{ trans('admin.lbl-search') }}
</div>
<!--     -->
<div class="panel-body">
    <div class="row">
        <div class="col-md-6">
            <label for="team" class="col-md-6">{{ trans('user.lbl-team') }}</label>
            <div class="col-md-6">
                {{ Form::select('team', $teams, null, ['class' => 'form-control search', 'id' => 'team']) }}
            </div>
        </div>
     </div>
     <!--  -->
     <div class="row margintop">
        <div class="col-md-6">
            <label for="team" class="col-md-6">{{ trans('project.lbl-start-day') }}</label>
            <div class="col-md-6">
                {{ Form::date('start_day', \Carbon\Carbon::now(), [ 'class' => 'form-control', 'id' => 'start-day'] ) }}
            </div>
        </div>

        <div class="col-md-6">
            <label for="team" class="col-md-6">{{ trans('project.lbl-end-day') }}</label>
            <div class="col-md-6">
                {{ Form::date('end_day', \Carbon\Carbon::now(), [ 'class' => 'form-control', 'id' => 'end-day']) }}
            </div>
        </div>
    </div>
    <!--  -->
    <div class="row margintop">
        <div class="col-md-3 col-md-offset-9">
            <button type="button" class="btn btn-primary" id="btn-search">{{ trans('admin.lbl-search') }}</button>
        </div>
    </div>
</div>

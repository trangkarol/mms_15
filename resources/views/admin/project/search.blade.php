<div class="panel-heading">
    {{ trans('admin.lbl-search') }}
</div>
<!--     -->
<div class="panel-body">
    <div class="col-md-6 col-md-offset-5">
        <div class="form-group">
            <label for="team" class="col-md-3">{{ trans('user.lbl-team') }}</label>
            <div class="col-md-6">
                {{ Form::select('team', $teams, null, ['class' => 'form-control', 'id' => 'team']) }}
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary" id="btn-search">{{ trans('admin.lbl-search') }}</button>
            </div>
        </div>
    </div>
</div>

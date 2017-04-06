<div class="x_content">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> {{ trans('admin.lbl-search') }} </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                    <div class="clearfix"></div>
                </div>
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group col-md-6">
                        <label for="team" class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('user.lbl-team') }}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{ Form::select('team', $teams, null, ['class' => 'form-control search', 'id' => 'team']) }}
                        </div>
                    </div>

                    <div class="form-group col-md-6{{ $errors->has('startDay') ? ' has-error' : '' }}">
                        <label for="team" class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('project.lbl-start-day') }}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{ Form::date('start_day', \Carbon\Carbon::now(), [ 'class' => 'form-control', 'id' => 'start-day'] ) }}
                        </div>

                        <span class="help-block has-error">
                            <strong class="err-startDay"></strong>
                        </span>
                    </div>

                    <div class="form-group col-md-6{{ $errors->has('endDay') ? ' has-error' : '' }}">
                        <label for="team" class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('project.lbl-end-day') }}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{ Form::date('end_day', \Carbon\Carbon::now(), [ 'class' => 'form-control', 'id' => 'end-day']) }}
                        </div>

                        <span class="help-block">
                           <strong class="err-endDay"></strong>
                        </span>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-10">
                            <button type="button" class="btn btn-success" id="btn-search">{{ trans('admin.lbl-search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel panel-heading">
        {{ trans('admin.form-comfirm.title') }}
    </div>
    <div class="panel panel-body">
        <div class="form-group">
            {{ trans('admin.form-comfirm.question') }}
        </div>
        <div class="form-group">
            {{ Form::radio('type_export', 'csv', null, ['class' => 'type_export']) }} {{ trans('admin.form-comfirm.csv') }}
        </div>
        <div class="form-group">
            {{ Form::radio('type_export', 'xls', null, ['class' => 'type_export']) }} {{ trans('admin.form-comfirm.Excel2003') }}
        </div>
        <div class="form-group">
            {{ Form::radio('type_export', 'xlsx', null, ['class' => 'type_export']) }} {{ trans('admin.form-comfirm.Excel2010') }}
        </div>
        <div class="col-md-4 col-md-offset-3">
            {{ Form::button(trans('admin.btn-ok'), ['class' => 'btn btn-primary', 'id' => 'btn-add-export']) }}
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel panel-heading">
        {{ trans('user.lbl-skill') }}
    </div>
    <div id ="result-skill">
        @include('admin.user.list_skill')
    </div>


    <div class="table-responsive">
        <h4>{{ trans('user.lbl-list-skill') }}</h4>
        <div class="table-result">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="hidden"></th>
                        <th >{{ trans('user.lbl-skill') }}</th>
                        <th >{{ trans('user.lbl-experiensive')}}</th>
                        <th >{{ trans('user.lbl-level') }}</th>
                        <th ></th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($skills as $skill)
                    @if(!in_array($skill->id, $skillId))
                        <tr>
                            <td class="hidden skillId">{{ $skill->id }}
                            </td>
                            <td>{{ $skill->name }}</td>
                            <td>
                                {{ Form::text('exeper', null, ['class' => 'form-control exeper', 'id' => 'name']) }}
                            </td>
                            <td>
                                {{ Form::select('levels', $levels, null, ['class' => 'form-control level']) }}
                            </td>
                            <td>
                                <div class="col-md-12">
                                    {!! Form::button(trans('admin.lbl-add'), ['class' => 'btn btn-primary btn-add-skill' ]) !!}
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

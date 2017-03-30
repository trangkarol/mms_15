@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('skill.title-skills') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{trans('skill.title-skills')}}</h4>
        </div>

        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\SkillController@create') }}" class="btn btn-primary"><i class="fa fa-plus " ></i></a>
        </div>
    </div>
    <!-- content -->
    <div class="row">
         <div class="col-md-12 paddingtop">
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('skill.lbl-list-skill') }}
                </div>
                <!--  -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th >{{ trans('admin.lbl-stt') }}</th>
                                    <th >{{ trans('skill.lbl-name') }}</th>
                                    <th ></th>
                                </tr>
                            </thead>

                            <tbody>
                            @if (!empty($skills))
                                @foreach ($skills as $skill)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $skill->name }}</td>
                                        <td class="col-md-3">
                                            <div class="col-md-6">
                                                <a href ="{{ action('Admin\SkillController@edit', $skill->id) }}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                                            </div>
                                            <div class="col-md-6">
                                                {{ Form::open(['action' => 'Admin\SkillController@destroy', 'id' => 'form-delete-skill']) }}

                                                {{ Form::hidden('skillId', $skill->id) }}
                                                {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary', 'id' => 'btn-delete-skill', 'type' => 'submit']) !!}
                                                {{ Form::close() }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>

                        </table>
                        @if (isset($skills))
                            {{ $skills->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

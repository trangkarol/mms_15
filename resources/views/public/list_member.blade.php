@extends('public.block.main')
<!-- title off page -->
@section('title')
    {{ trans('public.title-public') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-5 sub-menu">
            <h4>  {{ trans('public.title-list-member') }} <strong>{{ $nameTeam[0] }}</strong> </h4>
        </div>
    </div>
    <div class="panel panel-primary" style="margin-top:10px;">
        <!--  -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th >{{ trans('team.lbl-stt') }}</th>
                            <th >{{ trans('team.lbl-name') }}</th>
                            <th >{{ trans('team.lbl-position') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                    @if(!empty($members))
                        @foreach ($members as $member)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ action('Member\HomeController@detailMember', $member->user->id) }}">{{ $member->user->name }}</a>
                                </td>
                                <td>
                                    @foreach ($member->positions as $position)
                                        {{ $position->name }}
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                @if (isset($members))
                    {{ $members->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->

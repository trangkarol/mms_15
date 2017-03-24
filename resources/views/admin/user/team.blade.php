<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="hidden"></th>
                    <th >{{ trans('team.lbl-stt') }}</th>
                    <th >{{ trans('team.lbl-name') }}</th>
                    <th >{{ trans('team.lbl-position') }}</th>
                    <th ></th>
                </tr>
            </thead>

            <tbody>
            @php
                $index = 0;
            @endphp
            @foreach ($positionTeams as $positionTeam)

                @if($positionTeam->team)
                    @php
                        $index = $index + 1;
                    @endphp
                    <tr>
                        <td class="hidden teamId">{{ $positionTeam->team->id}}</td>
                        <td class="text-center">{{ $index }}</td>
                        <td>{{ $positionTeam->team->name }}</td>
                        <td>
                            @if ($positionTeam->position)
                                @foreach ($positionTeam->positions as $positon)
                                    {{ $positon->name }} @php echo ',' @endphp
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <div class="col-md-6">
                                {!! Form::button(trans('admin.lbl-edit'), ['class' => 'btn btn-primary btn-edit-team', 'id' => '']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary btn-delete-team', 'id' => '']) !!}
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>

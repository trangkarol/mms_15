{!! Form::open(['class' => 'form-horizontal']) !!}
    <div class="col-md-12">
            @foreach ($userSkills as $userSkill)
                <div class="col-md-6">
                    {!! Form::checkbox('users[]', $userSkill->user->id, null, ['class' => 'users' ]) !!} {{ $userSkill->user->name }}
                </div>
            @endforeach
    </div>
{{ Form::close() }}

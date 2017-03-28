{!! Form::open(['class' => 'form-horizontal']) !!}
    <div class="col-md-12">
        @foreach ($users as $user)
            @if(!$user->skills->isEmpty())
                <div class="col-md-6">
                    {{ Form::checkbox('users[]', $user->id, null, ['class' => 'users' ]) }} {{ $user->name }}
                </div>
            @endif
        @endforeach
    </div>
{{ Form::close() }}

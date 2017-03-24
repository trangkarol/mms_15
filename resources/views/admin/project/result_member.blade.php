@foreach ($members as $member)
    <div class="col-md-12">
        <div class="checkbox col-md-6">
            <label>{{ Form::checkbox('member[]', $member->id) }} {{ $member->name }}</label>
        </div>
    </div>
@endforeach

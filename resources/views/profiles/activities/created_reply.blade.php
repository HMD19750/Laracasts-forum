@component('profiles.activities.activity')

@slot('heading')
    {{ $profileUser->name }} replied to "
    <a href="{{ $activity->subject->thread->path() }}">
        <i>{{ $activity->subject->thread->title }}</i>"
    </a>
@endslot

@slot('body')
    {{ $activity->subject->body }}
@endslot

@endcomponent

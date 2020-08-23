<div id="reply-{{ $reply->id }}" class="card mt-2">

    <div class="card-header">

        <div class="level">

            <h5 class="flex">
                <a href="{{ url('/profiles') }}/{{ $reply->owner->name }}" >
                {{ $reply->owner->name }}
            </a>
            said {{ $reply->created_at->diffForHumans() }} ...
            </h5>

            <div>
                    <form method="POST" Action="{{url('replies')}}/{{ $reply->id }}/favorites" >
                    @csrf
                    <button type='submit' class='btn btn-link' {{ $reply->isFavorited()? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ Str::plural('Favorite',$reply->favorites_count ) }}
                    </button>
                </form>
            </div>
        </div>

    </div>

    <div class="card-body">
        {{$reply->body}}
    </div>

    @can('update',$reply)
        <div clas="card-footer ">
            <form method="POST" action="{{ url('/replies') }}/{{ $reply->id }}">
                @csrf
                @method("DELETE")
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </div>
    @endcan

</div>

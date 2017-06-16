<div class="comment">
    <div class="row">
        <div class="col-md-push-4 col-md-6 comment-edit">
            {{--Lien vers la route pour supprimer le commentaire--}}
            {{--<form id="delete-comment-{{$comment->id}}" action="{{ route("comments.destroy",compact("comment")) }}" method="post">--}}
                {{--{{ method_field('DELETE') }}--}}
                {{--{!! csrf_field() !!}--}}
            {{--</form>--}}
            {{ $comment->content }}
        </div>
    </div>
    <div class="row">
        <div class=" col-md-push-4 col-md-6 comment-edit-infos">
            <span hidden>{{ $comment->created_at->setLocale('fr') }}</span>
            <p>{{ $comment->created_at->diffForHumans() }}</p>
        </div>
    </div>
</div>

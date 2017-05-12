<div>
    <div class="row">
        <div class="col-md-push-4 col-md-6 comment-edit">
            {{--Lien vers la route pour supprimer le commentaire--}}
            <form id="delete-comment-{{$comment->id}}" action="{{ route("comments.destroy",compact("comment")) }}" method="post">
                {{ method_field('DELETE') }}
                {!! csrf_field() !!}
            </form>
            <a href="javascript:void(0);" onclick="document.getElementById('delete-comment-{{$comment->id}}').submit();"><span class="glyphicon glyphicon-remove comment-remove"></span></a>
            {{ $comment->content }}
        </div>
    </div>
    <div class="row">
        <div class=" col-md-push-4 col-md-6 comment-edit-infos">
            <p>{{ $comment->created_at->diffForHumans() }} | {{ $comment->user->name }}</p>
        </div>
    </div>
</div>

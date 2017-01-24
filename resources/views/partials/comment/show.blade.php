<div>
    <div class="row">
        <div class="col-md-push-4 col-md-6" style="border: solid 1px #000; border-bottom: 0px;">
            {{ $comment->content }}
        </div>
    </div>
    <div class="row">
        <div class=" col-md-push-4 col-md-6" style="border: solid 1px #000; border-top: 0px;">
            <p>{{ $comment->created_at->diffForHumans() }} | {{ $comment->user->name }}</p>
        </div>
    </div>
</div>
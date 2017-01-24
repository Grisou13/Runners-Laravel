<form action="{{ $route }}" method="post" class="form-horizontal">
    <label for="stat" class="col-md-4 control-label">Comments</label>
    <div class="col-md-6 col-md-offset-4">
        <div class="row">
            <div class="row col-md-12">
                <textarea name="content" disabled></textarea>
            </div>
            <div class="row col-md-12">
                <select name="user" class="col-md-4" id="" disabled>
                    @foreach(App\User::all() as $user)
                        <option value="{{ $user->id }}" {{ auth()->check() && auth()->user()->id == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                <button type="submit" disabled class="btn btn-default col-md-7"><span>Add comment</span></button>
            </div>
            {{ csrf_field() }}
        </div>
    </div>
</form>
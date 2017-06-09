<!--
*User: Joel.DE-SOUSA
-->
<tr class="entity" onclick="document.location = '{{ route("cars.show", $car) }}'">
    <td>{{ $car->name }}</td>
    <td>{{ $car->plate_number }}</td>
    <td>{{ $car->brand }}</td>
    <td>{{ $car->model }}</td>
    <td>
      <a class="comment-add">
        <span class="glyphicon glyphicon-plus"></span>
      </a>
      @if(count($car->comments))
      <a class="comment-hover">
        <span class="glyphicon glyphicon-comment"></span>
      </a>
      @endif
      <div class="comments">
        @foreach($car->comments as $comment)
          <div class="comment">
            <div class="comment-content">{{$comment->content}}</div>
            <div class="comment-info">{{ $comment->created_at->diffForHumans() }} | {{ $comment->user->name }}</div>
          </div>
          <hr>
        @endforeach
      </div>
    </td>
</tr>

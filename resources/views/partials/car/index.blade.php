<table class="table table-striped table-bordered">
  <thead>
      <tr>
          <td>ID</td>
          <td>Licence</td>
          <td>Brand</td>
          <td>Model</td>
          <td>Color</td>
          <td>Seats</td>
          <td>Comment</td>
          <td>shortname</td>
      </tr>
  </thead>
  <tbody>
  @each("partials.car.show",$cars,"car")
  </tbody>
</table>

<table class="table table-striped table-bordered">
  <thead>
      <tr>
          <td>Licence</td>
          <td>Brand</td>
          <td>Model</td>
          <td>seats</td>
      </tr>
  </thead>
  <tbody>
  @each("partials.car.list_item",$cars,"car")
  </tbody>
</table>

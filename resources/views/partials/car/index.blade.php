<table class="table table-striped table-bordered">
  <thead>
      <tr>
          <td>ID</td>
          <td>Name</td>
          <td>Email</td>
          <td>Nerd Level</td>
          <td>Actions</td>
      </tr>
  </thead>
  <tbody>
  @each("partials.car.show",$cars,"car")
  </tbody>
</table>

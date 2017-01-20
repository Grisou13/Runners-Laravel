<table class="table table-striped table-bordered">
  <thead>
      <tr>
          <td>First name</td>
          <td>Last name</td>
          <td>Telephone number</td>
          <td>Status</td>
      </tr>
  </thead>
  <tbody>
  @each("partials.user.list_item",$users,"user")
  </tbody>
</table>

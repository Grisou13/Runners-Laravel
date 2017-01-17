<table class="table table-striped table-bordered">
  <thead>
      <tr>
          <td>First name</td>
          <td>Last name</td>
          <td>Shortname</td>
          <td>Email</td>
          <td>Phone number</td>
          <td>Sex</td>
      </tr>
  </thead>
  <tbody>
  @each("partials.user.show",$users,"user")
  </tbody>
</table>

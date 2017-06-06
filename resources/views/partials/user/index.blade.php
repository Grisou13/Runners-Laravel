<!--
User: Joel.DE-SOUSA
-->
<table class="table table-striped table-bordered">
  <thead>
      <tr>
          <td>Prénom</td>
          <td>Nom</td>
          <td>Numéro de téléphone</td>
      </tr>
  </thead>
  <tbody>
  @each("partials.user.list_item",$users,"user")
  </tbody>
</table>

<!--
User: Joel.DE-SOUSA
-->
<table class="table table-striped table-bordered">
  <thead>
      <tr>
          <td>Licence</td>
          <td>Marque</td>
          <td>Modèle</td>
          <td>Commentaires</td>
      </tr>
  </thead>
  <tbody>
  @each("partials.car.list_item",$cars,"car")
  </tbody>
</table>

<!--
*User: Joel.DE-SOUSA
-->
  <tr class="entity" onclick="document.location = '{{ route("users.show", $user) }}'">
      <td>{{ $user->firstname }}</td>
      <td>{{ $user->lastname }}</td>
      <td>{{ $user->phone_number }}</td>
  </tr>

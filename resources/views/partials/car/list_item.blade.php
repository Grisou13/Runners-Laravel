<!--
*User: Joel.DE-SOUSA
-->
<tr class="entity" onclick="document.location = '{{ route("cars.show", $car) }}'">
    <td>{{ $car->plate_number }}</td>
    <td>{{ $car->brand }}</td>
    <td>{{ $car->model }}</td>
    <td>{{ $car->nb_place }}</td>
</tr>

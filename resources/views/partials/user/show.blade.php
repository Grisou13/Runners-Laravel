<!--
User: Joel.DE-SOUSA
-->
<tr>
    <td>{{ $user->firstname }}</td>
    <td>{{ $user->lastname }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->phone_number }}</td>
    <td>{{ $user->sex }}</td>
    <td>{{ $user->stat }}</td>
    <td><img src="http://fr.qr-code-generator.com/phpqrcode/getCode.php?cht=qr&chl={{$user->accesstoken}}&chs=180x180&choe=UTF-8&chld=L|0" alt="" height="200" width="200"></td>

    <!-- we will also add show, edit, and delete buttons -->
    <td>

    </td>
</tr>

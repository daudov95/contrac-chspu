<table>
    <thead>
    <tr>
        <th>ФИО</th>
        <th>Должность</th>
        <th>Категория</th>
        <th>E-mail</th>
        <th>Пароль</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->rank }}</td>
            <td>{{ $user->category }}</td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
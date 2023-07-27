<table>
    <thead>
    <tr>
        <th>Имя</th>
        <th>Email</th>
        <th>Должность</th>
        <th>Критерия</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->rank }}</td>
            <td>
                @if($user->criteria_id === 1)
                    Критерия 1
                @elseif($user->criteria_id === 2)
                    Критерия 2
                @elseif($user->criteria_id === 3)
                    Критерия 3
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
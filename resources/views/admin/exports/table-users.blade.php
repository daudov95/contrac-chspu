<table>
    <thead>
    <tr>
        <th>ФИО</th>
        <th>Должность</th>
        <th>Категория</th>
        <th>Научно-исследовательская работа</th>
        <th>Учебная и учебно-метадическая работа</th>
        <th>Воспитательная и иная работа</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->rank }}</td>
            <td>{{ $user->criteria_id == 1 ? "ассистент, преподаватель, старший преподаватель, административно-управленческий и учебно-вспомогател" : "доцент, профессор, научный работник" }}</td>
            @php
                $b1 = $type1->where('user_id', $user->id)->sum('points');
                $b2 = $type2->where('user_id', $user->id)->sum('points');
                $b3 = $type3->where('user_id', $user->id)->sum('points');
            @endphp
            <td>{{ $b1 ? $b1 : '0' }}</td>
            <td>{{ $b2 ? $b2 : '0' }}</td>
            <td>{{ $b3 ? $b3 : '0' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
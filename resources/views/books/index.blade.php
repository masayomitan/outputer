<tbody>
    @if(isset($admins))  // $adminデータ存在チェック
        @foreach ($admins as $admin)  // テーブル作成
            <tr>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->admin_code }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->role}}</td>
            </tr>
        @endforeach
<

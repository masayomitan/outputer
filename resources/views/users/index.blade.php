<a href={
    <div class="table-responsive">
        <table class="table table-striped">
            <thead><tr><th>{{ __('ID') }}</th><th>{{ __('Name') }}</th></tr></thead>
            <tbody>
                @foreach($all_users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->screen_name }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->self_introduction}}</td>
                    <td>{{ $user->profile_image}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

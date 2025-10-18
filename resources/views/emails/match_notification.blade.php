<h1>New Profile Match Found!</h1>
<p>Hi there,</p>
<p>Your profile matches with the following users:</p>
<ul>
    @foreach ($data as $user)
        <li>{{ $user['name'] }} (ID: {{ $user['user_id'] }})</li>
    @endforeach
</ul>
@foreach ($Users as $user)
    <button onclick="changeuser('{{ $user->name }}',{{ $user->id }})">
        {{ $user->name }} </button>
@endforeach

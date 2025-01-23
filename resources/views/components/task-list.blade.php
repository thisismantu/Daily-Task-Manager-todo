<tbody>
    @foreach ($tasks as $data)
        <tr class="list list-{{ $data->user->id }}" id="list-{{ $data->user->id }}">
            <td> {{ $loop->iteration }} </td>
            <td> {{ $data->user->name }} </td>
            <td id="task_name_{{ $data->id }}"> {{ $data->name }} </td>
            <td id="task_description_{{ $data->id }}"> {{ $data->task_description }} </td>
            <td>
                <select class="select">
                    <option>Done</option>
                    <option>Pending</option>
                    <option>Inprocess</option>
                </select>
            </td>
            <td>{{ $data->created_at }}</td>
            <td>{{ $data->updated_at }}</td>
            <td>
                <button onclick="enableEdit({{ $data->id }},'{{ $data->user->name }}','{{ $data->task_description }}');" class="buton-rto"> <i class="bi bi-pencil-fill"></i>
                </button>
                <button onclick="viewRow({{ $data->id }})" class="buton-update" title="view"> <i
                        class="bi bi-eye-fill"></i>
                </button>
            </td>
        </tr>
    @endforeach
</tbody>

@push('script')
<script>
    function enableEdit(id, task_name, task_description) {
        // Correct string interpolation
        $("#task_name_" + id).html(`<textarea id="details-${id}" class="inputarea">${task_name}</textarea>`);
        $("#task_description_" + id).html(`<textarea id="task_description-${id}" class="inputarea">${task_description}</textarea>`);
    }
</script>
@endpush

@if (count($tasks) > 0)
    @foreach ($tasks as $data)
        <form method="post" id="edit-task-{{ $data->id }}" action="{{ route('task.update', $data->id) }}">
            @csrf
            @method('PUT')
            <tr class="list list-{{ $data->id }}" id="list-{{ $data->id }}">
                <td> {{ $loop->iteration }} </td>
                <td> {{ $data->user->name }} </td>
                <td id="task_name_{{ $data->id }}"> {{ $data->name }} </td>
                <td id="task_description_{{ $data->id }}">{{ $data->task_description }} </td>
                <td>
                    <select class="select" disabled id="status_{{ $data->id }}" name="status_{{ $data->id }}">
                        <option value="DONE" {{ $data->status === 'DONE' ? 'selected' : '' }}>Done</option>
                        <option value="PENDING" {{ $data->status === 'PENDING' ? 'selected' : '' }}>Pending</option>
                        <option value="IN-PROCESS" {{ $data->status === 'IN-PROCESS' ? 'selected' : '' }}>In Process
                        </option>
                    </select>
                </td>
                <td id="task_created_at_{{ $data->id }}">{{ $data->created_at }}</td>
                <td id="task_updated_at_{{ $data->id }}">{{ $data->updated_at }}</td>
                <td>
                    <button id="btn-edit-{{ $data->id }}"
                        onclick="enableEdit({{ $data->id }},'{{ route('task.show', $data->id) }}');"
                        class="buton-rto btn-edit-{{ $data->id }}"> <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button onclick="viewGrid({{ $data->id }})" class="buton-update" title="view"> <i
                            class="bi bi-eye-fill"></i>
                    </button>
                </td>
            </tr>
        </form>
    @endforeach
@else
    <tr class="list">
        <td colspan="8" class="text-center">{{ __('No Task found') }}</td>
    </tr>
@endif


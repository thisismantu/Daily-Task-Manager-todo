@extends('theme.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box-fixed">
                <div class="scroll-container" style="position:relative;">
                    <div class="scroll-content" id="scroll-content">
                        @foreach ($Users as $user)
                            <button onclick="changeuser('{{ $user->name }}',{{ $user->id }})" class="btn-user"
                                id="btn-user-{{ $user->id }}">
                                {{ $user->name }} </button>
                        @endforeach
                    </div>
                </div>
                <div class="box-fixed" style="margin-top:9px;">
                    <button class="scroll-button" id="left-btn" disabled style="margin-right:3px;"> <i
                            class="bi bi-chevron-left"></i> </button>
                    <button class="scroll-button" id="right-btn"><i class="bi bi-chevron-right"></i> </button>
                </div>
                <div class="button-addds" style="margin-left:5px;">
                    <a href="#" title="Add User" class="btrr btn" data-tooltip="Some info text" data-bs-toggle="modal"
                        data-bs-target="#exampleModaladd"
                        style="padding:0px 4px; color:#606060; background:#f0f0f0; border:1px solid #e2e2e2; border-radius:2px;">
                        <i class="bi bi-plus-circle"></i> </a>
                    {{-- <a href="#" title="edit Button" class="btrr btn"
                        style="padding: 0px 4px; color:#606060; background:#f0f0f0; border:non !important; border:1px solid #e2e2e2; border-radius:2px;">
                        <i class="bi bi-pencil-square"></i> </a> --}}

                    <a href="{{ route('task.index') }}" title="Regresh Button" class="btrr btn"
                        style="padding: 0px 4px; color:#606060; background:#f0f0f0; border:non !important; border:1px solid #e2e2e2; border-radius:2px;">
                        <i class="bi bi-arrow-repeat"></i> </a>


                </div>
            </div>
        </div>
        <div class="col-md-4">
            <form method="post" action="{{ route('task.export') }}">
                @csrf
                <div style=" display:flex; margin-top: 6px;">

                    <div>
                        <label style="font-size:15px;"> Date Filter: </label>
                        <input type="hidden" name="user_id" value="0" id="userIdsFilter" />
                        <input type="text" name="daterange"
                            style="background:#fafafa;  border: 1px solid #dedddd; border-radius: 3px; font-size: 15px; outline:none; padding:5px 10px; " />
                    </div>
                    <button type="submit" class="btn" style="padding:0px 9px; margin-left:6px; background:#f0f0f0;"> <i
                            class="bi bi-cloud-download"></i> </button>



                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-status-detial" style=" margin-top:5px;">
                    <div class="table-responsive-box" style="overflow-y:auto; height:600px;">
                        <table class="table mt-2" style="width:100%" id="data-table">
                            <thead>
                                <x-add-task-form />
                                <tr>
                                    <th style="background:#f4f4f4;">&nbsp; </th>
                                    <th width="120" style="background:#f4f4f4;"> User </th>
                                    <th width="200" style="background:#f4f4f4;"> Task </th>
                                    <th width="360" style="background:#f4f4f4;"> Description </th>
                                    <th width="100" style="background:#f4f4f4;"> Status </th>
                                    <th style="background:#f4f4f4;"> Create Date </th>
                                    <th style="background:#f4f4f4;"> Modify Date </th>
                                    <th width="130px;" style="background:#f4f4f4;"> Action </th>
                                </tr>
                            </thead>
                            <tbody id="taskResponse">
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('Loading Data ...') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-add-user-modal />
    @push('script')
        <script>
            function changeuser(name, uid) {
                const inputField = document.getElementById('inputField');
                inputField.value = name;
                // $(".list").show();
                // $(".list").hide();
                // $(".list-" + uid).show();
                $('#name').prop('disabled', false);
                $('#task_description').prop('disabled', false);
                $('#submitTask').prop('disabled', false);
                $("#user_id").val(uid);
                $(".btn-user").removeClass('active');
                $("#btn-user-" + uid).addClass('active');
                $("#userIdsFilter").val(uid);
                callTaskList(uid);
            }

            $(document).ready(function() {
                callTaskList(0);
            });

            function callTaskList(user_id) {
                $.ajax({
                    url: "{{ route('task.index') }}",
                    method: 'GET',
                    data: {
                        user_id: user_id
                    },
                    success: function(response) {
                        $('#taskResponse').html(response);
                    },
                    error: function(xhr, status, error) {
                        $('#taskResponse').text('An error occurred: ' + error);
                        console.error(xhr.responseText);
                    }
                });
            }


            // function callTaskListUsingDate(startDate, endDate) {
            //     $.ajax({
            //         url: "{{ route('task.index') }}",
            //         method: 'GET',
            //         data: {
            //             user_id: user_id
            //         },
            //         success: function(response) {
            //             $('#taskResponse').html(response);
            //         },
            //         error: function(xhr, status, error) {
            //             $('#taskResponse').text('An error occurred: ' + error);
            //             console.error(xhr.responseText);
            //         }
            //     });
            // }

            function callUserList(user_id) {
                $.ajax({
                    url: "{{ route('users-master.index') }}",
                    method: 'GET',
                    data: {
                        user_id: user_id
                    },
                    success: function(response) {
                        $('#scroll-content').html(response);
                    },
                    error: function(xhr, status, error) {
                        $('#scroll-content').text('An error occurred: ' + error);
                        console.error(xhr.responseText);
                    }
                });
            }
        </script>
        <script>
            function enableEdit(id, taskurl) {
                // Correct string interpolation
                getTask(id, taskurl);
                $("#task_name_" + id).focus();
                $("#task_description_" + id).focus();
                $("#task_created_at_" + id).focus();

                // $("#btn-edit-" + id).html(
                //     `<button id="btn-save-" onclick="editTask(${id});"  class="buton-rto"> <i class="bi bi-floppy-fill"></i></button>`
                // );
                $("#status_" + id).prop('disabled', false);
                $("#btn-edit-" + id)
                    .attr("id", "btn-save-" + id)
                    .attr("onclick", "editTask(" + id + ");")
                    .html(`<i class="bi bi-floppy-fill"></i>`);
            }

            function editTask(id) {
                let updatedTaskName = $("#details-" + id).val();
                let created_at = $("#task_created_at-" + id).val();
                let updated_at = "{{ date('Y-m-d H:i:s') }}";
                let updatedTaskDescription = $("#task_description-" + id).val();
                let status = $("#status_" + id).val();
                $.ajax({
                    url: $("#edit-task-" + id).attr("action"),
                    method: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        name: updatedTaskName,
                        task_description: updatedTaskDescription,
                        created_at: created_at,
                        status: status
                    },
                    success: function(response) {
                        const task_get_url = "{{ url('task/') }}/" + id;
                        //         $("#btn-edit-" + id).html(`<button id="btn-edit-${id}"
                //     onclick="enableEdit(${id},'${task_get_url}');"
                //     class="buton-rto"> <i class="bi bi-pencil-fill"></i>
                // </button>`);

                        $("#btn-save-" + id)
                            .attr("id", "btn-edit-" + id)
                            .attr("onclick", "enableEdit(" + id + ",'" + task_get_url + "');")
                            .html(`<i class="bi bi-pencil-fill"></i>`);
                        flasher.success('Task updated successfully!');
                        $("#status_" + id).prop('disabled', true);
                        $("#details-" + id).hide();
                        $("#task_description-" + id).hide();
                        $("#task_name_" + id).text(updatedTaskName);
                        $("#task_description_" + id).text(updatedTaskDescription);
                        $("#task_created_at_" + id).text(created_at);
                        $("#task_updated_at_" + id).text(updated_at);
                        $("#task_name_" + id).find("button").remove();
                        // window.location = "{{ route('task.index') }}";
                    },
                    error: function(xhr, status, error) {
                        flasher.error('An error occurred while updating the task.');
                        console.error(xhr.responseText);
                    }
                });
            }

            function getTask(id, task_get_url) {
                $.ajax({
                    url: task_get_url,
                    method: "GET",
                    success: function(response) {

                        let created_at = dateFormatter(response.created_at);
                        $("#task_name_" + response.id).html(
                            `<textarea id="details-${id}" class="inputarea">${response.name}</textarea>`);
                        $("#task_description_" + id).html(
                            `<textarea id="task_description-${response.id}" class="inputarea">${response.task_description}</textarea>`
                        );
                        $("#task_created_at_" + response.id).html(
                            `<input type="text" id="task_created_at-${id}" class="form-control" value="${created_at}" />`
                        );

                    },
                    error: function(xhr, status, error) {
                        flasher.error('An error occurred while getting the task.');
                        console.error(xhr.responseText);
                    }
                });



            }

            function viewGrid(id) {

                $("#list-" + id).addClass("bg-light");
            }


            function dateFormatter(dates) {
                var isoString = dates;
                var formattedDate = moment(isoString).format('YYYY-MM-DD HH:mm:ss');
                return formattedDate;
            }
        </script>
    @endpush
@endsection

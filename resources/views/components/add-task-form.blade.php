<tr>
    <form action="javascript:void(0);" method="POST" id="taskForm">
        @csrf
        <th><input type="hidden" placeholder="user_id" name="user_id" id="user_id" class="form-control input-table"></th>
        <th><input type="text" id="inputField" class="form-control input-table" disabled
                style="background:#007bff; color:#FFF; border-bottom:none; border-radius:4px !important;" readonly></th>
        <th><input type="text" name="name" placeholder="Enter Your User Task *" disabled id="name"
                class="form-control input-table" required></th>
        <th><input type="text" name="task_description" placeholder="Enter Your Description *" disabled
                id="task_description" class="form-control input-table" required></th>
        <th><button type="submit" disabled id="submitTask" style="border:1px solid #e5dbdb; border-radius:2px;">
                Save
            </button></th>
    </form>
</tr>

@push('script')
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to check if all required fields are filled
            function checkFormValidity() {
                let name = $('#name').val().trim();
                let taskDescription = $('#task_description').val().trim();
                if (name && taskDescription) {
                    $('#submitTask').prop('disabled', false);
                } else {
                    $('#submitTask').prop('disabled', true);
                }
            }

            // Check fields when user types
            $('#name, #task_description').on('input', function() {
                checkFormValidity();
            });

            // Submit form via AJAX
            $('#taskForm').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                let form = $(this);

                // Validate form before submitting
                if (!form[0].checkValidity()) {
                    alert('Please fill out all required fields.');
                    return;
                }

                $.ajax({
                    url: "{{ route('task.store') }}",
                    method: "POST",
                    data: form.serialize(),
                    success: function(response) {


                        flasher.success(response.msg);
                        $('#submitTask').prop('disabled',true);
                        $("#name").val('');
                        $("#task_description").val('');
                        callTaskList($("#user_id").val());
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        alert('An error occurred while saving the task.');
                        console.error(xhr.responseText);
                    }
                });
            });
        });


    </script>
@endpush

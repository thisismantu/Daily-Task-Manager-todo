<div class="modal fade" id="exampleModaladd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headderbox-bg">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size:15px;">Add Username </h5>
                <button type="button" class="btn-close model-close-btn" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body body-padding">
                <div class="boxsquare-fild">
                    <form action="javascript:void(0);" id="userForm" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Enter Your User Name *" name="username"
                                        id="username" required class="form-control">
                                    <input type="hidden" name="name" id="namex" value="" required
                                        class="form-control">
                                    <input type="hidden" name="mobile" value="{{ rand(1111111111, 9999999999) }}"
                                        id="mobile" required class="form-control">
                                    <input type="hidden" name="email"
                                        value="dev.{{ rand(1111111, 999999) }}@gmail.com" id="email" required
                                        class="form-control">
                                    <input type="hidden" name="password" value="123456780" id="password" required
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="boxflex">
                                    <button class="btn btn-primary Butoon-btn" id="submit" style="padding:5px 13px;">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to check if all required fields are fille
            // Submit form via AJAX
            $('#userForm').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                $("#namex").val($("#username").val());
                let form = $(this);
                $.ajax({
                    url: "{{ route('users-master.store') }}",
                    method: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        flasher.success(response.msg);
                        form[0].reset();
                        callUserList(0);
                        $("#exampleModaladd").modal("hide");
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        flasher.error("user already exists");;
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush

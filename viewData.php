<div class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header"> Upload JSON File</div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <!-- <form action="dbOperation.php" method="post" enctype="multipart/form-data"> -->
                    <form class="user" id="fileForm" name="fileForm">
                        <div>
                            Select image to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                        <label id="fileToUpload_error" class="error"></label>
                        <br>
                        <div>
                            <input type="submit" value="Submit" name="submit">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
    var fileForm = $("#fileForm").validate({
        ignore: ".ignore",
        rules: {
            fileToUpload: {
                required: true,
            },
        },
        invalidHandler: function(f, v) {
            // validateAll("bankBreadCrums");
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            var placement = $(element).data("error");
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {

            var fileToUpload = document.querySelector("input[name='fileToUpload']")
                .files[0];

            var data_info = new FormData();
            data_info.append("fileFunction", true);
            data_info.append("fileToUpload", fileToUpload);

            x = document.querySelectorAll(".error");
            for (i = 0; i < x.length; i++) {
                x[i].textContent = "";
            }

            $.ajax({
                type: "POST",
                url: "/dbOperation.php",
                data: data_info,
                processData: false,
                contentType: false,
                cache: false,
                mimeType: "multipart/form-data",
                //   headers: { token: localStorage.getItem("token") },
                success: function(response_data) {

                    var response_data = JSON.parse(response_data);
                    if (response_data.status) {
                        Swal.fire({
                            icon: "succes",
                            // title: "Oops...",
                            text: response_data.message,
                        });
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response_data.message,
                        });
                    }
                },
            });
        },
    });
</script>
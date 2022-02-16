</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your abc.com 2022</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

                <button class="btn btn-primary" type="button" id="logoutButton" data-dismiss="modal">Logout</button>

            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#example').DataTable();

    });


    $("#logoutButton").on("click", function() {

        var api_token = localStorage.getItem("api_token");

        var data_info = new FormData();
        data_info.append("logoutFunction", true);
        data_info.append("api_token", api_token);

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
            success: function(response_data) {
                var response_data = JSON.parse(response_data);
                if (response_data.status) {
                    Swal.fire({
                        icon: "succes",
                        // title: "Oops...",
                        text: response_data.message,
                    });
                    setTimeout(function() {
                        window.location.replace("index.php");
                    }, 1000);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: response_data.message,
                    });
                }
            },
        });
    });
</script>
</body>

</html>
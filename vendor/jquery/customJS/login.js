// loginForm submit end here
var loginForm = $("#loginForm").validate({
  ignore: ".ignore",
  rules: {
    email: {
      required: true,
    },
    password: {
      required: true,
    },
  },
  invalidHandler: function (f, v) {
    // validateAll("bankBreadCrums");
  },
  errorElement: "div",
  errorPlacement: function (error, element) {
    var placement = $(element).data("error");
    if (placement) {
      $(placement).append(error);
    } else {
      error.insertAfter(element);
    }
  },
  submitHandler: function (form) {
    var email = $("#email").val();
    var password = $("#password").val();

    var data_info = new FormData();

    data_info.append("loginFunction", true);
    data_info.append("email", email);
    data_info.append("password", password);

    x = document.querySelectorAll(".error");
    for (i = 0; i < x.length; i++) {
      x[i].textContent = "";
    }

    $.ajax({
      type: "POST",
      url: "/dbOperation.php/checkLogin",
      data: data_info,
      processData: false,
      contentType: false,
      cache: false,
      mimeType: "multipart/form-data",
      //   headers: { token: localStorage.getItem("token") },
      success: function (response_data) {
        var response_data = JSON.parse(response_data);
        if (response_data.status) {
          localStorage.setItem("api_token", response_data.object.api_token);
          window.location.replace("home.php");
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
// loginForm submit end here

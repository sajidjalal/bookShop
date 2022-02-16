$("#searchResult").on("click", function () {
  var value = $("#value").val();
  var searchBy = $("#searchBy").val();
  if (!value) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Please Enter Deatils",
    });
    return;
  }
  if (!searchBy) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Please Select Search Type",
    });
    return;
  }

  window.location.replace("list.php?searchBy=" + searchBy + "&value=" + value);
});

var serachForm = $("#serachForm").validate({
  ignore: ".ignore",
  rules: {
    searchbByValue: {
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
    var searchbByValue = $("#searchbByValue").val();

    var data_info = new FormData();
    data_info.append("serachFunction", true);
    data_info.append("searchbByValue", searchbByValue);

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
      success: function (response_data) {
        var response_data = JSON.parse(response_data);
        if (response_data.status) {
          Swal.fire({
            icon: "succes",
            // title: "Oops...",
            text: response_data.message,
          });
          setTimeout(function () {
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

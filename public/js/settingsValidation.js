$(document).ready(function () {
  /**
   * Validate the form
   */

  $("#formEditUserPassword").validate({
    rules: {
      newUserPassword: {
        required: true,
        minlength: 6,
        maxlength: 20,
        validPassword: true,
      },
    },
    messages: {
      newUserPassword: {
        required: "Pole wymagane",
        minlength: "Minimalna długość hasła to 6 znaków",
        maxlength: "Maksymalna długość hasła to 20 znaków",
        validPassword: "Hasło musi zawierać przynajmniej 1 literę i 1 cyfrę",
      },
    },

    errorClass: "text-danger",
    errorPlacement: function ($error, $element) {
      var name = $element.attr("name");

      $("#error" + name).append($error);
    },
  });

  $("#formEditUserName").validate({
    rules: {
      newUserName: {
        required: true,
        maxlength: 20,
      },
    },
    messages: {
      newUserName: {
        required: "Pole wymagane",
        maxlength: "Imię max. 20 znaków",
      },
    },

    errorClass: "text-danger",
    errorPlacement: function ($error, $element) {
      var name = $element.attr("name");

      $("#error" + name).append($error);
    },
  });

  $("#formEditUserEmail").validate({
    rules: {
      newUserEmail: {
        required: true,
        email: true,
        //remote: "/account/validate-email",
      },
    },
    messages: {
      newUserEmail: {
        required: "Pole wymagane",
        email: "Podaj poprawny adres email",
        //remote: "Dla podanego adresu email przypisane jest już inne konto",
      },
    },

    errorClass: "text-danger",
    errorPlacement: function ($error, $element) {
      var name = $element.attr("name");

      $("#error" + name).append($error);
    },
  });
});

function onSubmit(token) {
  document
    .getElementById(
      "formEditUserPassword",
      "formEditUserName",
      "formEditUserEmail"
    )
    .submit();
}

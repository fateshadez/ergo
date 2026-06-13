let invalidData = false;

document.addEventListener("DOMContentLoaded", () => {
  const formName = document.querySelector("form").name;
  const re =
    /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  document.getElementById("form").addEventListener("submit", (event) => {
    let emailField = document.forms[formName]["email"].value.trim();
    let passwordField = document.forms[formName]["password"].value.trim();

    if (!emailField) {
      document.querySelector(".email-error-log").innerHTML =
        "<p class='text-red-500 text-sm'>Empty email</p>";
      invalidData = true;
    } else {
      document.querySelector(".email-error-log").innerHTML = "";
    }

    if (!passwordField) {
      document.querySelector(".password-error-log").innerHTML =
        "<p class='text-red-500 text-sm'>Empty password</p>";
      invalidData = true;
    } else if (passwordField.length < 8) {
      document.querySelector(".password-error-log").innerHTML =
        "<p class='text-red-500 text-sm'>Password must be at least 8 characters long.</p>";
      invalidData = true;
    } else if (!re.test(passwordField)) {
      document.querySelector(".password-error-log").innerHTML =
        "<p class='text-red-500 text-sm'>Password must have uppercase, lowercase, number and special character</p>";
      invalidData = true;
    } else {
      document.querySelector(".password-error-log").innerHTML = "";
    }

    if (formName === "sign-up-form") {
      let confPasswordField = document.forms[formName]["confirm_password"].value.trim();

      if (!confPasswordField) {
        document.querySelector(".conf-password-error-log").innerHTML =
          "<p class='text-red-500 text-sm'>Empty confirm password</p>";
        invalidData = true;
      } else if (confPasswordField !== passwordField) {
        document.querySelector(".conf-password-error-log").innerHTML =
          "<p class='text-red-500 text-sm'>Passwords don't match</p>";
        invalidData = true;
      } else {
        document.querySelector(".conf-password-error-log").innerHTML = "";
      }
    }

    if (invalidData) {
      event.preventDefault();
      invalidData = false;
    }
  });
});

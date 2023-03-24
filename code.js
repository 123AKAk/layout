$("#signup-form").submit(function (event)
  {
      reset();
      var username = $("#username").val();
      var email = $("#email").val();
      var country = $("#country").val();
      var gender = $("#gender").val();
      var password = $("#password").val();
      var confrimpassword = $("#confrimpassword").val();
      var agreed = $("#agreed").val();

      if (
          username == "" ||
          email == "" ||
          country == "" ||
          gender == "" ||
          password == "" ||
          confrimpassword == ""
      ) {
          alertify.error("Fill all Input Feilds");
      } else {
          if (ValidateEmail(email) == false) {
          alertify.error("Invalid Email, use a Valid Email");
          } else {
          if (password != confrimpassword) {
              alertify.error("Passwords are not the same");
          } else {
              if ($("#agreed").is(":checked")) {
              let formdata = new FormData();
              formdata.append("username", username);
              formdata.append("email", email);
              formdata.append("gender", gender);
              formdata.append("password", password);
              formdata.append("user_ip_address", "ipaddress");
              formdata.append("user_country", country);

              let loca = "classes/components/userComponents.php?dataPurpose=signup";
              fetch(loca, { method: "POST", body: formdata })
                  .then((res) => res.json())
                  .then((data) => {
                  console.log(data);
                  var result = (data);
                  if (result.response == true) 
                  {
                      alertify.success(result.message);
                      alertify.message("Redirecting...");
                      setTimeout(function () {
                      window.location.replace("login.php?loginMsg=1");
                      }, 3000);

                  } else {
                      alertify.set({ delay: 15000 });
                      alertify.error(result.message);
                  }
                  });
              } else {
              alertify.error("Accpet Terms and Agreement to continue");
              }
          }
          }
      }

      event.preventDefault();
  });
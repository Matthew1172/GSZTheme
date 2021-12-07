/*Call JQuery*/
(function ($) {
    $(document).ready(function () {

        $("#user_selector").on("change", function () {
            var selection = $(this).val();
            switch (selection) {
                case "student":
                    $("#studentPartB").show();
                    break;
                default:
                    $("#studentPartB").hide();
                    break;
            }
        });

        /**
         * Send User Sign Up
         */
         $("#signup").submit(function (event) {
            event.preventDefault();
            var fName = $("#signup-fName").val();
            var lName = $("#signup-lName").val();
            var email = $("#signup-email").val();
            var uid = $("#signup-uid").val();
            var pw = $("#signup-pw").val();
            var pw2 = $("#signup-pw2").val();

            var type = $("#user_selector").val();
            var eGPA = $("#student-gpa").val();

            $.ajax({
                beforeSend: function () {
                    $('#loading').show()
                },
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'call_signup',
                    first: fName,
                    last: lName,
                    email: email,
                    uid: uid,
                    pw: pw,
                    pw2: pw2,
                    e_gpa: eGPA,
                    type: type,
                },
                success: function (response) {
                    $("#signup-fName, #signup-lName, #signup-email, #student-gpa, #signup-uid, #signup-pw, #signup-pw2").removeClass("input-error");
                    switch (response['code']) {
                        case "emptyField":
                            $(".form-message").html("<h4 class='text-center form-error'>Please fill in all fields.</h4>");
                            $("#signup-fName, #signup-lName, #signup-email, #signup-uid, #signup-pw, #signup-pw2").addClass("input-error");
                            $("#student-gpa").addClass("input-error");
                            empty();
                            break;
                        case 'name':
                            $(".form-message").html("<h4 class='text-center form-error'>This name is not valid.</h4>");
                            $("#signup-fName, #signup-lName").addClass("input-error");
                            fail("This name is not valid.");
                            break;
                        case 'email':
                            $(".form-message").html("<h4 class='text-center form-error'>This email has been taken or it is not valid.</h4>");
                            $("#signup-email").addClass("input-error");
                            fail("This email has been taken or it is not valid.");
                            break;
                        case 'uid':
                            $(".form-message").html("<h4 class='text-center form-error'>This username has been taken or it is not valid.</h4>");
                            $("#signup-uid").addClass("input-error");
                            fail("This username has been taken or it is not valid.");
                            break;
                        case 'pwValid':
                            $(".form-message").html("<h4 class='text-center form-error'>Please put a valid password.</h4>");
                            $("#signup-pw").addClass("input-error");
                            fail("Invalid password.");
                            break;
                        case 'pwMatch':
                            $(".form-message").html("<h4 class='text-center form-error'>Passwords do not match.</h4>");
                            $("#signup-pw, #signup-pw2").addClass("input-error");
                            fail("Passwords do not match.");
                            break;
                        case 'eGPA':
                            $(".form-message").html("<h4 class='text-center form-error'>Student GPA is not valid.</h4>");
                            $("#student-gpa").addClass("input-error");
                            fail("Student GPA is not valid.");
                            break;
                        case 'userTaken':
                            $(".form-message").html("<h4 class='text-center form-error'>This username has been taken or it is not valid.</h4>");
                            $("#signup-uid").addClass("input-error");
                            fail("This username has been taken or it is not valid.");
                            break;
                        case 'emailTaken':
                            $(".form-message").html("<h4 class='text-center form-error'>This email has been taken or it is not valid.</h4>");
                            $("#signup-email").addClass("input-error");
                            fail("This email taken has been taken or it is not valid.");
                            break;
                        case 'success':
                            $(".form-message").html("<h4 class='text-center form-success'>Success.</h4>");
                            $("#signup-fName, #signup-lName, #signup-email, #student-gpa, #signup-uid, #signup-pw, #signup-pw2").val("");
                            var x = "Thank you for creating an account with Grad School Zero! Please await further instructions in the email you provided. Please note your account is under review, and during this time will be inactive.";
                            var url = response['url'];
                            alert(x);
                            window.location.assign(url);
                            break;
                        default:
                            appBreak();
                            break;
                    }
                }
            }).done(function (){
                $('#loading').hide();
            });

        });
    });
})(jQuery);

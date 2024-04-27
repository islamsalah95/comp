// Wait for the DOM to be ready
$(function () {

    $.validator.addMethod("email_check", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
    }, "Email Address is invalid: Please enter a valid email address.");

    $.validator.addMethod("password_check", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,16}$/i.test(value);
    }, "Passwords are 6-16 characters with uppercase letters, lowercase letters and at least one number.");

    $.validator.addMethod("regex", function (value, element, regex) {
        return this.optional(element) || regex.test(value);
    }, "Passwords are 6-16 characters with uppercase letters, lowercase letters and at least one number and symbol.");

    $.validator.addMethod("minDate", function (e) {
        var start_date = $('.start_date').val();
        var end_date = $('.end_date').val();
        if (start_date > end_date) {
            return false;
        }
        return true;
    }, "End date must be greater than Start date.");

    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='registration']").validate({
        // Specify validation rules
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            firstname: "required",
            lastname: "required",
            email: {
                required: true,
                // Specify that email should be validated
                // by the built-in "email" rule
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        // Specify validation error messages
        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address"
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    });

    // Initialize form validation on the login form.
    $("#login_form").validate({
        rules: {
            email: {
                required: true,
                email_check: true
            },
            password: {
                required: true,
                // pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{6,30}$/,
            }
        },
        messages: {
            password: {
                required: "Please provide a password",
                pattern: "Passwords are 6-16 characters with uppercase letters, lowercase letters and at least one number and symbol."
            },
            email: "Please enter a valid email address"
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#editCompanyForm").validate({
        rules: {
            company_email: {
                required: true,
                email_check: true
            },
            company_name: {
                required: true,
            },
            logopic: {
                maxsize: 2 * 1000 * 1000 //2MB
            }
        },
        messages: {
            logopic: {
                maxsize: "File size must not exceed 2MB.",
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#addUserFrom").validate({
        rules: {
            emp_name: {
                required: true
            },
            email: {
                required: true,
                email_check: true
            },
            password: {
                required: true,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{6,30}$/,
            },
            img: {
                maxsize: 2 * 1000 * 1000 //2MB
            },
            IdNumber: {
                required: true,
                number: true
            },
            EstLaborOfficeId: {
                required: true,
                number: true
            },
            EstSequenceNumber: {
                required: true,
                number: true
            }
        },
        messages: {
            password: {
                required: "Please provide a password",
                pattern: "Passwords are 6-16 characters with uppercase letters, lowercase letters and at least one number and symbol."
            },
            email: "Please enter a valid email address",
            img: {
                maxsize: "File size must not exceed 2MB.",
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#editPersonalInfo").validate({
        rules: {
            emp_name: {
                required: true
            },
            IdNumber: {
                required: true,
                number: true
            },
            EstLaborOfficeId: {
                required: true,
                number: true
            },
            EstSequenceNumber: {
                required: true,
                number: true
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#editLoginInfo").validate({
        rules: {
            email: {
                required: true,
                email_check: true
            },
            password: {
                required: true,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{6,30}$/,
            }
        },
        messages: {
            password: {
                required: "Please provide a password",
                pattern: "Passwords are 6-16 characters with uppercase letters, lowercase letters and at least one number and symbol."
            },
            email: "Please enter a valid email address",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#editProfileImage").validate({
        rules: {
            profilepic: {
                maxsize: 2 * 1000 * 1000 //2MB
            }
        },
        messages: {
            profilepic: {
                maxsize: "File size must not exceed 2MB.",
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#profileForm").validate({
        rules: {
            profilepic: {
                maxsize: 2 * 1000 * 1000 //2MB
            },
            emp_name: {
                required: true
            }
        },
        messages: {
            profilepic: {
                maxsize: "File size must not exceed 2MB.",
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#forgotPasswordForm").validate({
        rules: {
            password: {
                required: true,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{6,30}$/,
            },
            retypepassword: {
                equalTo: '[name="password"]'
            }
        },
        messages: {
            password: {
                required: "Please provide a password",
                pattern: "Passwords are 6-16 characters with uppercase letters, lowercase letters and at least one number and symbol."
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#form").validate({
        rules: {
            start_date: {
                required: true,
                dateISO: true
            },
            end_date: {
                required: true,
                dateISO: true,
                minDate: true
            }
        },
        messages: {
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#cv_form").validate({
        submitHandler: function (form) {
            form.submit();
        }
    });

});

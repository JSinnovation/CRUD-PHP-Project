$(document).ready(function () {
    $("#submit").click(function () {
        //e.preventDefault(); removed (e) from function above

        var email = $("#email").val();
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        var password = $("#password").val();

        var valid = true;

        if (firstname == "" || !isNameValid(firstname)) {
            valid = false;
            $("#errorFirstname").html("Firstname cannot be blank and must be between 5 and 15 characters");
        } else {
            $("#errorFirstname").html(""); //sets boolean to true
        }

        if (lastname == "" || !isNameValid(lastname)) {
            valid = false;
            $("#errorLastname").html("Lastname cannot be blank and must be between 5 and 15 characters");
        } else {
            $("#errorLastname").html(""); //sets boolean to true
        }

        if (email == "" || !isEmailValid(email)) {
            valid = false;
            $("#errorEmail").html("Enter a valid Email Address - Email cannot be blank");
        } else {
            $("#errorEmail").html(""); //sets boolean to true
        }

        if (password == "" || !isPasswordValid(password)) {
            valid = false;
            $("#errorPassword").html("Password must be between 7 and 15 chars and must contain at least one lowercase letter, one uppercase letter and one numeric value");
        } else {
            $("#errorPassword").html(""); //sets boolean to true
        }

        if (valid == true) {
            var from_data ={
                firstname: firstname,
                lastname: lastname,
                email: email,
                password: password 
            };
            $.ajax({
                url: "../scripts/insert.php",
                type: "POST",
                data: form_data,
                success: function(data){
                    
                }
                
            });

        } else {
            return false
        }
    });

});


function isNameValid(name){
    return /[A-Z]+/i.test(name) && /[a-z]+/.test(name) && /\S{5,15}/.test(name);
}

function isEmailValid(emailAddress){
    var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return pattern.test(emailAddress);
}

function isPasswordValid(string){
    return /[A-Z]+/.test(string) && /[a-z]+/.test(string) &&
    /[\d\W]/.test(string) && /\S{7,15}/.test(string)
}
 
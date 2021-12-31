/* Form validation: check if field is empty */
function hasValue($obj) {
    return $obj.val() !== "" && $obj.val() !== null;
}

/* Form validation: check if field meets minimum length of characters */
function meetsLengthRequirements($obj, minLength) {
    return $obj.val().length > minLength;
}

/* Form validation: check if field value is a valid email */
function validateEmail($obj) {
    return $obj.val().includes("@"); 
}

/* Form validation: check if confirm password field value matches password field value */
function passwordsMatch($pwd, $conf_pwd) {
    return $conf_pwd.val() == $pwd.val() || $pwd.val() == $conf_pwd.val();
}

/* Form validation: Add class to invalid fields  */
function invalidInput(element) {
    element.addClass("error");
}

/* Form validation: Remove class of invalid input fields and remove the error message text */
function valiInput(element) {
    element.removeClass("error");
    element.siblings('div.input-error-msg').text('');
}

$(document).ready(function() {

    $('#first_name, #last_name').blur(function(){
        hasValue($(this)) ? valiInput($(this)) : invalidInput($(this));
    });
    $('#first_name, #last_name').on('click keyup', function(){
        valiInput($(this));
    });

    $('#email').blur(function(){
        validateEmail($(this)) ? valiInput($(this)) : invalidInput($(this));
    });
    $('#email').keyup(function(){
        validateEmail($(this)) ? valiInput($(this)) : "";
    });

    $('#contact_number').on('keyup blur', function(){
        meetsLengthRequirements($(this), 10) ? valiInput($(this)) : invalidInput($(this));
    });

    $('#password').keyup(function(){
        meetsLengthRequirements($(this), 6) ? valiInput($(this)) : invalidInput($(this));
        passwordsMatch($('#password'), $('#confirm_password')) ? valiInput($('#confirm_password')) : $('#confirm_password').addClass("error");
    });

    $('#confirm_password').keyup(function(){
        passwordsMatch($('#password'), $('#confirm_password')) ? valiInput($(this)) : invalidInput($(this));
    });

    $(document).find('div.input-error-msg').each(function() {
        $(this).text() != "" ? $(this).siblings('input').addClass('error') : "" ;
    });
});
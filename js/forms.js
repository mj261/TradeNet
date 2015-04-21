function form_hash(form, username, password) {
    if (username.value == '' || password.value == '') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";

    // Finally submit the form. 
    form.submit();
    return true
}

function reg_form_hash(form, customer_number, username, email, password, conf) {
    // Check each field has a value
    if (customer_number.value == '' ||
        username.value == '' ||
        email.value == '' ||
        password.value == '' ||
        conf.value == '') {

        alert('You must provide all the requested details. Please try again');
        return false;
    }

    // Check the username
    re = /^\w+$/;
    if (!re.test(form.username.value)) {
        alert("Username must contain only letters, numbers and underscores. Please try again");
        form.username.focus();
        return false;
    }

    re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if (!re.test(form.email.value)) {
        alert("Email address is not valid. Please try again");
        form.email.focus();
        return false;
    }

    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 

    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }

    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }

    // Create a new element input, this will be our hashed password field.
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent.
    password.value = "";
    conf.value = "";

    // Finally submit the form.

    form.submit();
    return true;
}

function editformhash(form, name, username, email, oldpassword, password, conf) {

    // Check each field has a value
    if (name.value == '' ||
        username.value == '' ||
        email.value == '') {

        alert('You must provide all the requested details. Please try again');
        return false;
    }

    if (oldpassword.value == '') {
        alert('You must provide your current password. Please try again');
        return false;
    }

    if ((password.value != '' && conf.value == '') || (password.value == '' && conf.value != '')) {
        alert('You must provide both password fields. Please try again');
        return false;
    }

    // Check the username

    re = /^\w+$/;
    if (!re.test(form.username.value)) {
        alert("Username must contain only letters, numbers and underscores. Please try again");
        form.username.focus();
        return false;
    }

    re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if (!re.test(form.email.value)) {
        alert("Email address is not valid. Please try again");
        form.email.focus();
        return false;
    }

    if (password.value != '' && conf.value != '' && oldpassword != '') {
        // Check that the password is sufficiently long (min 6 chars)
        // The check is duplicated below, but this is included to give more
        // specific guidance to the user
        if (password.value.length < 6) {
            alert('Passwords must be at least 6 characters long.  Please try again');
            form.password.focus();
            return false;
        }

        // At least one number, one lowercase and one uppercase letter
        // At least six characters

        var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
        if (!re.test(password.value)) {
            alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
            return false;
        }

        // Check password and confirmation are the same
        if (password.value != conf.value) {
            alert('Your password and confirmation do not match. Please try again');
            form.password.focus();
            return false;
        }

        // Create a new element input, this will be our old hashed password field.
        var oldp = document.createElement("input");

        // Add the new element to our form.
        form.appendChild(oldp);
        oldp.name = "oldp";
        oldp.type = "hidden";
        oldp.value = hex_sha512(oldpassword.value);


        // Create a new element input, this will be our hashed password field.
        var p = document.createElement("input");

        // Add the new element to our form.
        form.appendChild(p);
        p.name = "p";
        p.type = "hidden";
        p.value = hex_sha512(password.value);

        // Make sure the plaintext password doesn't get sent.
        oldpassword.value = "";
        password.value = "";
        conf.value = "";

        // Finally submit the form.
        form.submit();
        return true;
    }
    else {
        // Make sure the plaintext password doesn't get sent.
        oldpassword.value = "";
        password.value = "";
        conf.value = "";

        // Finally submit the form.
        form.submit();
        return true;
    }
}

function editformhashAdmin(form, name, username, email, password, conf) {

    // Check each field has a value
    if (name.value == '' ||
        username.value == '' ||
        email.value == '') {

        alert('You must provide all the requested details. Please try again');
        return false;
    }

    if ((password.value != '' && conf.value == '') || (password.value == '' && conf.value != '')) {
        alert('You must provide both password fields. Please try again');
        return false;
    }

    // Check the username

    re = /^\w+$/;
    if (!re.test(form.username.value)) {
        alert("Username must contain only letters, numbers and underscores. Please try again");
        form.username.focus();
        return false;
    }

    re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if (!re.test(form.email.value)) {
        alert("Email address is not valid. Please try again");
        form.email.focus();
        return false;
    }


    if (password.value != '' && conf.value != '') {
        // Check that the password is sufficiently long (min 6 chars)
        // The check is duplicated below, but this is included to give more
        // specific guidance to the user
        if (password.value.length < 6) {
            alert('Passwords must be at least 6 characters long.  Please try again');
            form.password.focus();
            return false;
        }

        // At least one number, one lowercase and one uppercase letter
        // At least six characters

        var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
        if (!re.test(password.value)) {
            alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
            return false;
        }

        // Check password and confirmation are the same
        if (password.value != conf.value) {
            alert('Your password and confirmation do not match. Please try again');
            form.password.focus();
            return false;
        }

        // Create a new element input, this will be our hashed password field.
        var p = document.createElement("input");

        // Add the new element to our form.
        form.appendChild(p);
        p.name = "p";
        p.type = "hidden";
        p.value = hex_sha512(password.value);

        // Make sure the plaintext password doesn't get sent.
        password.value = "";
        conf.value = "";

        // Finally submit the form.
        form.submit();
        return true;
    }
    else {
        // Make sure the plaintext password doesn't get sent.
        password.value = "";
        conf.value = "";

        // Finally submit the form.
        form.submit();
        return true;
    }
}


function test() {
    let form = document.forms['signup'];
    let username = form['username'].value;
    let email = form['email'].value;
    let password = form['password'].value;
    if (username.trim().length > 3 && passwordChecker(password) && validateEmail(email)) {
        return true;
    }
    let error = "";
    if (username.trim().length < 4)
        error += "Username must be at least 8 letters long, not including blanks.\r\n";
    if (!validateEmail(email))
        error += "Please enter a valid email address\r\n";
    if (!passwordChecker(password))
        error += "Password must be lat least 8 characters and contain at least one numeric value, one lowercase letter and one uppercase letter";
    alert(error)
    return false;

}
function validateEmail(email) {
    if (email.lastIndexOf(".") > email.indexOf("@") + 2 && email.indexOf("@") > 0 && email.length - email.lastIndexOf(".") > 2) {
        return true;
    }
    return false;
}
function passwordChecker(password) {
    if (password.trim().length > 7 && hasNumeric(password) && hasUppercase(password) && hasLowercase(password))
        return true;
    return false;
}
function hasNumeric(s) {
    for (let i = 0; i < s.length; i++) {
        const c = s[i];
        if (!isNaN(c))
            return true;
    }
    return false;
}
function hasUppercase(s) {
    for (let i = 0; i < s.length; i++) {
        const c = s[i];
        if (isNaN(c) && c == c.toUpperCase())
            return true;
    }
    return false;
}
function hasLowercase(s) {
    for (let i = 0; i < s.length; i++) {
        const c = s[i];
        if (isNaN(c) && c == c.toLowerCase())
            return true;
    }
    return false;
}
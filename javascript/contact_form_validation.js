// Javascript Task 1. Validate Contact Form

function validateForm() {
    var name = document.forms["contactForm"]["name"].value;
    var email = document.forms["contactForm"]["email"].value;
    var phone = document.forms["contactForm"]["phone"].value;
    var select = document.forms["contactForm"]["select"].value;
    var comment = document.forms["contactForm"]["comment"].value;
    

    // Validate that something has been entered into the name field
    if (name == "") {
        alert ("Your must enter your name.");
        return false;
    }
    // Validate email address
    else if (email == "") {
        alert ("You must enter your email address.");
        return false;
    }
    else if (email.indexOf("@")<0) {
		alert ("There must be an @ in your email address.");
		return false;
	}
	else if (email.indexOf("@") != email.lastIndexOf("@")) {
		alert ("There cannot be more than one @ in your email address.");
		return false;
	}
	else if (email.indexOf(".")<0) {
		alert ("There must be at least one . in your email address.");
		return false;
	}
	else if (email.indexOf(".")<email.indexOf("@")) {
		alert ("There must be at least . following the @ in your email address.");
		return false;
	}

    // Validate phone number
    else if (phone == "") {
        alert ("You must enter your phone number.");
        return false;
    }
    else if (phone.length < 6 || phone.length > 11) {
        alert ("The phone number you entered is not valid.");
        return false;
    }

    // Validate select menu
    else if (select == "") {
        alert ("You must select an enquiry type.");
        return false;
    }

    // Validate comment box
    else if (comment == "") {
        alert ("You must leave a comment.");
        return false;
    }

// Javascript Task 2. Confirm contact form details
    var confirmed = confirm("Thank you for your enquiry. Please confirm the details you have entered:" + "\n"
                + "Full Name: " + name + "\n"
                + "Email: " + email + "\n"
                + "Phone Number: " + phone + "\n"
                + "Enquiy Type: " + select + "\n"
                + "Comments: " + comment);
    // If details are correct, submit the form
    if (confirmed == true) {
        alert ("Thank you, your enquiry has bee submitted");
    }
    return confirmed;
}
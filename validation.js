function validFirstName() {
    //Read in the given name entered
    var firstName = document.getElementById('pracFirstName').value;
    //create the reg ex pattern for given name
    var firstNameRegEx = /^[a-zA-Z' ]+$/;
    //compare regex with user input
    if(firstName.match(firstNameRegEx)) {
        //given name valid
        document.getElementById('firstNameError').innerHTML = 'OK!';
        document.getElementById('firstNameError').style.color = 'black';
    } else {
        //given name invalid
        document.getElementById('firstNameError').innerHTML = 'First name can only contain a-z, A-Z, apostrophe and spaces';
        document.getElementById('firstNameError').style.color = 'red';

    }
}

function validLastName() {
    //read in the family name entered
    var lastName = document.getElementById('pracLastName').value;
    //create the reg ex pattern for family name
    var lastNameRegEx = /^[a-zA-Z' ]+$/;
    //compare regex with user input
    if(lastName.match(lastNameRegEx)) {
        //family name valid
        document.getElementById('lastNameError').innerHTML = 'OK!';
        document.getElementById('lastNameError').style.color = 'black';
    } else {
        //family name invalid
        document.getElementById('lastNameError').innerHTML = 'Family name can only contain a-z, A-Z, apostrophe and spaces';
        document.getElementById('lastNameError').style.color = 'red';
    }
}

function validUsername() {
    //read in the username entered
    var username = document.getElementById('pracUsername').value;
    //read in list of existing usernames
    //var usernameList = '<?php echo $usernameList; ?>'.split(",");
    //var usernameList = <?php echo $usernameList; ?>;
    //for(var i=0; i < usernameList.length; i++){
	//   document.write("<li>"+usernameList[i]+"</li>");
    //}
    //create the reg ex pattern for username
    var usernameRegEx = /^\w+$/;
    //compare regex with user input
    if(username.match(usernameRegEx)) {
        //username valid
        document.getElementById('usernameError').innerHTML = 'OK!';
        document.getElementById('usernameError').style.color = 'black';
    } else {
        //username invalid
        document.getElementById('usernameError').innerHTML = 'Username can only contain, letters, number or underscores';
        document.getElementById('usernameError').style.color = 'red';
        //check if username already exists
        //for(var i = 0; i < usernameList.length; i++) {
        //    if(username == usernameList[i]) {
        //        document.getElementById('usernameError').innerHTML = 'Username already exists';
        //    }
        //}
    }

}

function validPassword() {
    //read in the password entered
    var password = document.getElementById('pracPassword').value;
    //create the reg ex pattern for password
    var passwordRegEx = /^\S{4,}$/;
    //compare regex with user input
    if(password.match(passwordRegEx)) {
        //password valid
        document.getElementById('passwordError').innerHTML = 'OK!';
        document.getElementById('passwordError').style.color = 'black';
    } else {
        //password invalid
        document.getElementById('passwordError').innerHTML = 'Password must be at least 4 non-whitespace characters long';
        document.getElementById('passwordError').style.color = 'red';
    }
}

function validBirthDate() {
    //read in dob entered
    var birthDate = document.getElementById('subBirthDate').value;
    //create reg ex pattern for dob
    var birthDateRegEx = /^\d{1,2}\/\d{2}\/\d{4}$/;
    //reset some flags
    ageCheckBool = false;
    oldCheckBool = false;
    //compare regex with user input
    if(birthDate.match(birthDateRegEx)) {
        var firstSlashIndex = birthDate.indexOf("/");
        if (firstSlashIndex == 2) {
            //format is valid, extract numbers from user input
            var day = parseInt(birthDate.substring(0, 2));
            var month = parseInt(birthDate.substring(3, 5));
            var year = parseInt(birthDate.substring(6, 10));
        } else if (firstSlashIndex == 1) {
            var day = parseInt(birthDate.substring(0, 1));
            var month = parseInt(birthDate.substring(2, 4));
            var year = parseInt(birthDate.substring(5, 9));    
        }
        //check dob entered is within age limits using global booleans ageCheckBool and oldCheckBool. True = valid, false = invalid. Both must be true.
        dateChecker(day, month, year);
        if ((ageCheckBool == true) && (oldCheckBool == true)) {
            //dob is valid
            document.getElementById('birthDateError').innerHTML = 'OK!';
            document.getElementById('birthDateError').style.color = 'black'
        }
    } else {
        //dob in wrong format
        document.getElementById('birthDateError').innerHTML = 'Must be in dd/mm/yyyy or d/mm/yyyy format';
        document.getElementById('birthDateError').style.color = 'red';
    }
    
}

function dateChecker(day, month, year) {
    
    //If the month is valid
    if((month >= 1) && (month <= 12)) {
        //If the day is valid for a given month
        switch(month) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                //days entered valid for 31 day month
                if ((day >= 1) && (day <= 31)) {
                    //check persion is at least 18 years old
                    ageCheckBool = ageCheck(day, month, year);
                    //check realistic date has been put in (< 120 years)
                    oldCheckBool = oldCheck(day, month, year);
                } else {
                    //days entered invalid for 31 day month
                    document.getElementById('birthDateError').innerHTML = 'Day invalid for given month';
                    document.getElementById('birthDateError').style.color = 'red';
                    ageCheckBool = false;
                }
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                //days entered valid for 30 day month
                if ((day >= 1) && (day <= 30)) {
                    //check persion is at least 18 years old
                    ageCheckBool = ageCheck(day, month, year);
                    //check realistic date has been put in (< 120 years)
                    oldCheckBool = oldCheck(day, month, year);
                } else {
                    //days entered invalid for 30 day month
                    document.getElementById('birthDateError').innerHTML = 'Day invalid for given month';   
                    document.getElementById('birthDateError').style.color = 'red';
                    ageCheckBool = false;
                }
                break;
            case 2:
                //days entered valid for february (take into account leap year)
                if ((day >= 1) && (((day <= 29) && (year%4 === 0)) || (day <= 28))) {
                    //check persion is at least 18 years old
                    ageCheckBool = ageCheck(day, month, year);
                    //check realistic date has been put in (< 120 years)
                    oldCheckBool = oldCheck(day, month, year);
                } else {
                    //days entered invalid for february
                    document.getElementById('birthDateError').innerHTML = 'Day invalid for given month and year';  
                    document.getElementById('birthDateError').style.color = 'red';
                    ageCheckBool = false;
                }
                break;         
            } 
    } else {
        //month entered is invalid
        document.getElementById('birthDateError').innerHTML = 'Month invalid';  
        document.getElementById('birthDateError').style.color = 'red';
    }
}

//only allow dates in the past
function ageCheck(day, month, year) {
    //get the current date for validating data
    var currentDate = new Date();
    //Check if older than 0 years old
    if (currentDate.getFullYear()-year > 0) {
        document.getElementById('birthDateError').innerHTML = 'OK!';
        return true;
    } else {
        //check by exactly 0 by year first
        if (currentDate.getFullYear()-year==0) {
            //check age is 0 by month
            if ((currentDate.getMonth()+1) == month) {
                //check age is at least 0 by day
                if (day < currentDate.getDate()) {
                    document.getElementById('birthDateError').innerHTML = 'OK!';
                    return true;
                } else {
                    //not at least 0 years old
                    document.getElementById('birthDateError').innerHTML = 'Must give date in the past';
                    document.getElementById('birthDateError').style.color = 'red';
                    return false;
                }
            } else {
                //check age is at least 0 by month
                if (month < (currentDate.getMonth()+1)) {
                    //at least 0 years old
                    document.getElementById('birthDateError').innerHTML = 'OK!';
                    return true;
                } else {
                    //not 0
                    document.getElementById('birthDateError').innerHTML = 'Must give date in the past';
                    document.getElementById('birthDateError').style.color = 'red';
                    return false;
                }
            }
        } else {
            //not 0
            document.getElementById('birthDateError').innerHTML = 'Must give date in the past';
            document.getElementById('birthDateError').style.color = 'red'; 
            return false;
        }  
    }
}

//check a realistic date has been put in
function oldCheck(day, month, year) {
    //get the current date for validating data
    var currentDate = new Date();
    //check dob is not more than 120 years old
    if (currentDate.getFullYear()-year < 120) {
        return true;   
    } else {
        document.getElementById('birthDateError').innerHTML = 'Unrealistic date';
        document.getElementById('birthDateError').style.color = 'red'; 
        return false;
    }
}

function validSex() {
    //read in the sex entered
    var sex = document.getElementById('subSex').value;
    //create the reg ex pattern for sex
    var sexRegEx = /^[mf]{1}$/;
    //compare regex with user input
    if(sex.match(sexRegEx)) {
        //sex valid
        document.getElementById('sexError').innerHTML = 'OK!';
        document.getElementById('sexError').style.color = 'black';
    } else {
        //sex invalid
        document.getElementById('sexError').innerHTML = 'Sex can only contain m or f';
        document.getElementById('sexError').style.color = 'red';
    }
}

function validDescription() {
    //read in description entered
    var desc = document.getElementById('description').value;
    //create the reg ex pattern for description ID
    var descRegEx = /^[a-zA-Z_]+$/;
    //compare regex with user input
    if(desc.match(descRegEx)) {
        //description valid
        document.getElementById('descriptionError').innerHTML = 'OK!';
        document.getElementById('descriptionError').style.color = 'black';
    } else {
        //description invalid
        document.getElementById('descriptionError').innerHTML = 'Description was contain letters or underscores';
        document.getElementById('descriptionError').style.color = 'red';
    }
}

function validTrueFallsRisk() {
    //read in true falls risk entered
    var trueFallsRisk = document.getElementById('trueFallsRisk').value;
    //var trueFallsRiskFloat = floatval(trueFallsRisk);
    //create the reg ex pattern for trueFallsRisk
    var trueFallsRiskRegEx = /^\-?[0-9]+(\.[0-9]+)?$/;
    //compare regex with user input
    if(trueFallsRisk.match(trueFallsRiskRegEx) && (trueFallsRisk >= -5) && (trueFallsRisk <= 5)) {
        //true falls risk valid
        document.getElementById('trueFallsRiskError').innerHTML = 'OK!';
        document.getElementById('trueFallsRiskError').style.color = 'black';
    } else {
        //true falls risk invalid
        document.getElementById('trueFallsRiskError').innerHTML = 'True falls risk must be a number between -5 and 5';
        document.getElementById('trueFallsRiskError').style.color = 'red';
    }
    
}

function validateForm() {
    var validation1 = document.getElementById('firstNameError').innerHTML;
    var validation2 = document.getElementById('lastNameError').innerHTML;
    var validation3 = document.getElementById('birthDateError').innerHTML;
    var validation4 = document.getElementById('sexError').innerHTML;
    if ((validation1 == 'OK!') && (validation2 == 'OK!') && (validation3 == 'OK!') && (validation4 == 'OK!')) {
        return true;
    } else {
        alert("Ensure all details are entered correctly");
        return false;
    }
}

function validateTestTrialForm() {
    var validation1 = document.getElementById('birthDateError').innerHTML;
    var validation2 = document.getElementById('descriptionError').innerHTML;
    var validation3 = document.getElementById('trueFallsRiskError').innerHTML;
    if ((validation1 == 'OK!') && (validation2 == 'OK!') && (validation3 == 'OK!')) {
        return true;
    } else {
        alert("Ensure all details are entered correctly");
        return false;
    }
}



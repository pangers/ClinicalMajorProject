function validSearchPhrase() {
    //retrieve the search phrase and search criteria
    var searchPhrase = document.getElementById('searchPhrase').value;
    var dropDownList = document.getElementById('searchCriteria');
    var searchCriteria = dropDownList.options[dropDownList.selectedIndex].value;
    
    //depending on which search criteria chosen, use the corresponding validation function
    if (searchCriteria == 'firstName') {
        //create the reg ex pattern for given name
        var firstNameRegEx = /^[a-zA-Z' ]+$/;
        //compare regex with user input
        if(searchPhrase.match(firstNameRegEx)) {
            //given name valid
            document.getElementById('searchPhraseError').innerHTML = 'OK!';
            document.getElementById('searchPhraseError').style.color = 'black';
        } else {
            //given name invalid
            document.getElementById('searchPhraseError').innerHTML = 'First name can only contain a-z, A-Z, apostrophe and spaces';
            document.getElementById('searchPhraseError').style.color = 'red';
        }
      
    } else if (searchCriteria == 'lastName') {
        //create the reg ex pattern for family name
        var lastNameRegEx = /^[a-zA-Z' ]+$/;
        //compare regex with user input
        if(searchPhrase.match(lastNameRegEx)) {
            //family name valid
            document.getElementById('searchPhraseError').innerHTML = 'OK!';
            document.getElementById('searchPhraseError').style.color = 'black';
        } else {
            //family name invalid
            document.getElementById('searchPhraseError').innerHTML = 'Family name can only contain a-z, A-Z, apostrophe and spaces';
            document.getElementById('searchPhraseError').style.color = 'red';
        }
    
    } else if (searchCriteria == 'birthDate') {
        //create reg ex pattern for dob
        var birthDateRegEx = /^\d{2}\/\d{2}\/\d{4}$/;
        //compare regex with user input
        if(searchPhrase.match(birthDateRegEx)) {
            //dob is valid
            document.getElementById('searchPhraseError').innerHTML = 'OK!';
            document.getElementById('searchPhraseError').style.color = 'black'
        } else {
            //dob in wrong format
            document.getElementById('searchPhraseError').innerHTML = 'Must be in dd/mm/yyyy format';
            document.getElementById('searchPhraseError').style.color = 'red';
        }
        
    } else if (searchCriteria == 'sex') {
        //create the reg ex pattern for sex
        var sexRegEx = /^[mf]{1}$/;
        //compare regex with user input
        if(searchPhrase.match(sexRegEx)) {
            //sex valid
            document.getElementById('searchPhraseError').innerHTML = 'OK!';
            document.getElementById('searchPhraseError').style.color = 'black';
        } else {
            //sex invalid
            document.getElementById('searchPhraseError').innerHTML = 'Sex can only contain m or f';
            document.getElementById('searchPhraseError').style.color = 'red';
        }
        
    } 
}

function validateSearchForm() {
    var validation1 = document.getElementById('searchPhraseError').innerHTML;
    if (validation1 == 'OK!') {
        return true;
    } else {
        alert("Ensure search phrase is entered correctly");
        return false;
    }
}

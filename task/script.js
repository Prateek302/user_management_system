function ValidateEmail() {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(addform.email.value)) {
      return true;
  }
  else{
     alert("You have entered an invalid email address!");
     return false;
    }
}
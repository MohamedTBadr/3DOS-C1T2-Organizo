window.addEventListener('load',toggleForm('credit'))
function toggleForm(e){
  document.getElementById('formType').innerHTML = e === 'credit' ? `<div class="form-floating mt-3">
    <input id="nameOnCard" type="text" class="form-control">
    <label for="nameOnCard">Name On Card</label>
  </div>
  <div class="form-floating mt-3">
    <input id="cardNumber" type="text" class="form-control">
    <label for="cardNumber">Card Number</label>
  </div>
  <div class="row g-3">
    <div class="col">
      <div class="form-floating mt-3">
        <input id="expiry_mm" type="text" class="form-control">
        <label for="expiry_mm">Expiry (mm)</label>
      </div>
    </div>
    <div class="col">
      <div class="form-floating mt-3">
        <input id="cvv" type="text" class="form-control">
        <label for="cvv">CVV</label>
      </div>
    </div>
  </div>` : `<div class="form-floating mt-3">
    <input id="accountHolder" type="text" class="form-control">
    <label for="accountHolder">Name of Account Holder</label>
  </div>
  <div class="form-floating mt-3">
    <input id="routing" type="text" class="form-control">
    <label for="routing">Routing Number</label>
  </div>
  <div class="form-floating mt-3">
    <select name="accountType" id="accountType" class="form-control">
      <option value="checking">Checking</option>
      <option value="savings">Savings</option>
    </select>
    <label for="accountType">Account Type</label>
  </div>`
}

function validateNum() {
  const num = document.getElementById("card-number-input").value;
  const numError = document.getElementById("numError");
  
  if (num === "") {
      numError.textContent = "Card Number is required";
      numError.style.display = "block";
      return false;
  } else if (num.length !== 16) {
      numError.textContent = "Card Number must be 16 digits";
      numError.style.display = "block";
      return false;
  } else {
      numError.textContent = "";
      numError.style.display = "none";
      return true;
  }
}

function validateName() {
  const name = document.getElementById("card-holder-input").value;
  const nameError = document.getElementById("nameError");
  
  if (name === "") {
      nameError.textContent = "Card Holder Name is required";
      nameError.style.display = "block";
      return false;
  } else {
      nameError.textContent = "";
      nameError.style.display = "none";
      return true;
  }
}

function validateMonth() {
  const month = document.getElementById("month-input").value;
  const monthError = document.getElementById("monthError");
  
  if (month === "month") {
      monthError.textContent = "Month is required";
      monthError.style.display = "block";
      return false;
  } else {
      monthError.textContent = "";
      monthError.style.display = "none";
      return true;
  }
}

function validateYear() {
  const year = document.getElementById("year-input").value;
  const yearError = document.getElementById("yearError");
  
  if (year === "year") {
      yearError.textContent = "Year is required";
      yearError.style.display = "block";
      return false;
  } else {
      yearError.textContent = "";
      yearError.style.display = "none";
      return true;
  }
}

function validateCvv() {
  const cvv = document.getElementById("cvv-input").value;
  const cvvError = document.getElementById("cvvError");
  
  if (cvv === "") {
      cvvError.textContent = "CVV is required";
      cvvError.style.display = "block";
      return false;
  } else if (cvv.length !== 3) {
      cvvError.textContent = "CVV must be 3 digits";
      cvvError.style.display = "block";
      return false;
  } else {
      cvvError.textContent = "";
      cvvError.style.display = "none";
      return true;
  }
}

function validateForm() {
  const isNumValid = validateNum();
  const isNameValid = validateName();
  const isMonthValid = validateMonth();
  const isYearValid = validateYear();
  const isCvvValid = validateCvv();

  return isNumValid && isNameValid && isMonthValid && isYearValid && isCvvValid;
}

document.querySelector('form').onsubmit = function(e) {
  if (!validateForm()) {
      e.preventDefault();
  }
};

// Attach event listeners for validation on input change
document.getElementById('card-number-input').oninput = validateNum;
document.getElementById('card-holder-input').oninput = validateName;
document.getElementById('month-input').oninput = validateMonth;
document.getElementById('year-input').oninput = validateYear;
document.getElementById('cvv-input').oninput = validateCvv;



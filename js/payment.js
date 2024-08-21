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
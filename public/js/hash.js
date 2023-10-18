const button = document.querySelector(".reset-password-button")

button.addEventListener("click", function (event) {
  event.preventDefault()

  const password_input = document.querySelector(".reset-password-input")
  const password_confirmation_input = document.querySelector(".reset-password-confirmation-input")


  const email = document.querySelector(".email-input").value
  const password = password_input.value
  const password_confirmation = password_confirmation_input.value

  if (email && password && password_confirmation && password === password_confirmation) {
    const hash_password = CryptoJS.SHA256(password + email).toString()
    const hash_password_confirmation = CryptoJS.SHA256(password_confirmation + email).toString()

    password_input.value = hash_password
    password_confirmation_input.value = hash_password_confirmation

    document.querySelector(".reset-password-form").submit()

    // Now, submit the form with the updated password field
  }
});
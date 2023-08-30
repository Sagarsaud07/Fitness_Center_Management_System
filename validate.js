function validateForm(event) {
  event.preventDefault(); // Prevent form submission

  // Get input values
  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;

  // Perform validation
  if (username === '' || password === '') {
    displayErrorMessage('Please enter both username and password.');
  } else {
    
    validateCredentials(username, password);
  }
}

function displayErrorMessage(message) {
  var errorMessage = document.getElementById('error-message');
  errorMessage.textContent = message;
  errorMessage.style.display = 'block';
}

function validateCredentials(username, password) {
  // Here, you would typically make an AJAX request to the server to validate the credentials
  // You can use a fetch or XMLHttpRequest to send a request to your server-side code

  // Simulating server-side validation with a hardcoded admin credentials check
  if (username === 'sagar' && password === '12345678') {
    // Credentials are valid, redirect to the dashboard
    window.location.href = 'dashboard.html';
  } else {
    // Display error message for invalid credentials
    displayErrorMessage('Invalid username or password.');
  }
}

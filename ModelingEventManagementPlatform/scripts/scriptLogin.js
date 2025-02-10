document.addEventListener('DOMContentLoaded', () => {
  
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');

    if (error) {
        const errorMessageDiv = document.getElementById('error-message');
        errorMessageDiv.innerText = decodeURIComponent(error); 
        errorMessageDiv.style.display = 'block'; 
        errorMessageDiv.style.color = 'red'; 
        errorMessageDiv.style.textAlign = 'center';
        errorMessageDiv.style.marginTop = '20px';
        errorMessageDiv.style.border = '1px solid red';
        errorMessageDiv.style.padding = '10px';
        errorMessageDiv.style.borderRadius = '5px';
        errorMessageDiv.style.backgroundColor = '#ffe6e6'; 
    }
});


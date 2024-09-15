document.addEventListener('DOMContentLoaded', function () {
    // Function to fetch data from the server and update the table
    function loadUsers(searchText = "") {
        // Prepare the data to send to the server
        const formData = new FormData();
        
        formData.append('searchText', searchText);

        // // Use Fetch API to make a POST request to search.php
         fetch('./search.php', {
             method: 'POST',
             body: formData
         })
         .then(response => response.text())  // Convert the response to text (HTML)
         .then(data => {
         document.querySelector('#example tbody').innerHTML = data;  // Insert the HTML content into the table
         })
         .catch(error => console.error('Error:', error));  // Log any errors that occur
    }
    //end function

    // Fetch all users when the page loads
    loadUsers();

    // Listen to input changes in the search field
    document.querySelector('#searchText').addEventListener('input', function () {
        const searchText = this.value;

        // If input is empty, reload the page or clear the table
        if (searchText === "") {
            location.reload();
            return;
        }

        // Fetch filtered users based on search text
        loadUsers(searchText);
    });
});

$(document).ready(function() {
    $("#searchText").on("input", function() {
        var searchText = $(this).val();

        if (searchText === "") {
            location.reload();
            return;
        }

        $.ajax({
            url: "../ViewSprints.php?pid=<?php echo $pid ?>",
            type: "POST",
            data: { text: searchText, search: true },
            success: function(data) {
                var results = $(data).find('.pricing-card');
                $('.pricing-container').html(results);
            }
        });
    });
});

$('form').on('submit', function(e) {
    e.preventDefault();  // Prevent the form from submitting in the default way
    var searchText = $('#searchText').val();

    if (searchText === "") {
        location.reload();  // Reload page if search is cleared
        return;
    }

    $.ajax({
        url: "../ViewSprints.php?pid=<?php echo $pid ?>", // Same page
        type: "POST",
        data: { text: searchText, search: true },
        success: function(data) {
            var results = $(data).find('.pricing-card');
            $('.pricing-container').html(results);
        }
    });
});

    function validateName() {
    const sprint_name = document.getElementById("sprint_name").value;
    const nameError = document.getElementById("nameError");
    if (sprint_name === "") {
        nameError.textContent = "Sprint Name is required";
        nameError.style.display = "block";
        return false;
    } else {
        nameError.textContent = "";
        nameError.style.display = "none";
        return true;
    }
}

function validateDate() {
    const start_date = new Date(document.querySelector("input[name='start_date']").value);
    const end_date = document.getElementById("end_date").value;
    const endDate = new Date(document.getElementById("end_date").value);
    const dateError = document.getElementById("dateError");

    const timeDiff = (new Date(end_date) - start_date) / (1000 * 60 * 60 * 24);

    // dateError.textContent = "";
    // dateError.style.display = "none";

    if (end_date === "") {
        dateError.textContent = "End Date is required!";
        dateError.style.display = "block";
        return false;
    } else if (endDate < start_date) {
        dateError.textContent = "End Date can't be before start date!";
        dateError.style.display = "block";
        return false;
    } else if (timeDiff < 7 || timeDiff > 30) {
        dateError.textContent = "The sprint duration must be between 7 and 30 days!";
        dateError.style.display = "block";
        return false;
    } else {
        dateError.textContent = "";
        dateError.style.display = "none";
        return true;
    }
}

function validateForm() {
    const isNameValid = validateName();
    const isDateValid = validateDate();

    return isNameValid && isDateValid;
}

document.querySelector('form').onsubmit = function (e) {
    if (!validateForm()) {
        e.preventDefault();
    }
};


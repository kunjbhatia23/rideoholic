document.addEventListener("DOMContentLoaded", function () {
    // Perform an AJAX request to fetch user data
    const xhr = new XMLHttpRequest();
    document.addEventListener("mousemove", function (event) {
        // Adjust the threshold value as needed
        if (event.clientX > window.innerWidth - 20) {
            openUserCard();
        } else {
            closeUserCard();
        }
    });

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const userData = JSON.parse(xhr.responseText);

            // Update the user name in the HTML
            document.getElementById("userName").innerText = userData.name;
        }
    };

    // Adjust the URL to your server-side script
    xhr.open("GET", "get_user_data.php", true);
    xhr.send();
});


function openUserCard() {
    document.getElementById("userCard").style.right = "0";
}

function closeUserCard() {
    document.getElementById("userCard").style.right = "-300px";
}

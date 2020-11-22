let open_door = function (event) {
    let targetElement = event.target;
    // Set up our HTTP request
    let xhr = new XMLHttpRequest();

    // Setup our listener to process completed requests
    xhr.onreadystatechange = function () {
        // Process our return data

        console.log(this.responseText);
        if (this.readyState === 4) {
            if (this.status === 200) {
                // This will run when the request is successful
                console.log(xhr.response);
                window.location.assign('bin/ajax.php?download=true&monthday=' + targetElement.getAttribute('title'));
            } else {
                let response = JSON.parse(this.responseText);
                window.alert(response.message);
            }
        }

        // This will run either way
        // All three of these are optional, depending on what you're trying to do
        console.log('This always runs...');
    };

    // Create and send a GET request
    // The first argument is the post type (GET, POST, PUT, DELETE, etc.)
    // The second argument is the endpoint URL
    xhr.open('GET', 'bin/ajax.php?monthday=' + targetElement.getAttribute('title'));
    xhr.send();
};

window.addEventListener('load', function () {
    let map = document.querySelectorAll('#advent-map area');
    for (let i = 0; i < map.length; i++) {
        if (map[i].addEventListener) {
            map[i].addEventListener('click', open_door, false);
        }
    }
});

let open_door = function (event) {
    let targetElement = event.target;
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                window.location.assign('bin/ajax.php?download=true&monthday=' + targetElement.getAttribute('title'));
            } else {
                let response = JSON.parse(this.responseText);
                window.alert(response.message);
            }
        }
    };

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

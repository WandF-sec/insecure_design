document.addEventListener('DOMContentLoaded', function() {
    // Örnek AJAX işlevi
    function sendAjaxRequest(url, method, data, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                callback(xhr.responseText);
            }
        };
        xhr.send(data);
    }

    // Formların AJAX ile gönderilmesi (Örnek)
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(form);
            var data = new URLSearchParams(formData).toString();
            sendAjaxRequest(form.action, form.method, data, function(response) {
                console.log(response);
            });
        });
    }
});

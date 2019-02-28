function dataRequest(formData, callbackFunc, handler) {
    let request = new XMLHttpRequest();
    request.callback = callbackFunc;
    request.onload = xhrSuccess;
    request.onerror = xhrFail;
    request.open("POST", "/" + handler, true);
    request.send(formData);
}

function displayRequest(request) {

    if (request.status !== 200) {
        alert(request.status + ': ' + request.statusText);
        alert(request.responseText);
    } else {
        alert('status: ' + request.readyState + ' response :' + request.responseText);
        //location.reload();
    }
}

function xhrSuccess() {
   this.callback(this);
}

function xhrFail() {
    alert('status error: ' + this.readyState);
}

let logout = document.getElementById('logout');

if (logout) {
    logout.addEventListener('click', function () {
        dataRequest('', displayRequest, 'logout');
    })
}
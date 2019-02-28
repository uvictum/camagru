window.onload = function () {
    let sendBtn = document.querySelector('button.is-link');
    let passwd = document.getElementById('pass');
    let repPasswd = document.getElementById('passrepeat');
    let formHelper = document.getElementById('formHelper');
    let form = document.querySelector('form');

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        return false;
    });

    sendBtn.addEventListener("click", function () {
        if (passwd.value === repPasswd.value) {
            let formData = new FormData(form);
            dataRequest(formData, handleCabinetResponse, "update");
        } else {
            formHelper.className = "help is-danger";
            formHelper.innerText = "Passwords are not identical";
        }
    });

    function handleCabinetResponse(request) {
        if (request.status !== 200) {
            formHelper.className = "help is-danger";
            formHelper.innerText = request.responseText;
        } else {
          alert(request.responseText);
           //formHelper.className = "help is-success";
           //formHelper.innerText = request.responseText;
        }
    }
};
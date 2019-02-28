window.onload = function () {
    let signBtn = document.querySelector('button');
    let signHlp = document.getElementsByClassName('help')[0];
    let pass = document.getElementById('pass');
    let passRep = document.getElementById('pass_repeat');

    signBtn.addEventListener('click', function f() {
        let formData = new FormData(document.querySelector('form'));
        if (pass.value && passRep.value && pass.value === passRep.value) {
            dataRequest(formData, handleLoginResponse, 'signup');
        } else {
            signHlp.innerText = "Passwords should be identical and non-empty";
            signHlp.className = "help is-danger";
        }
    });

    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault();
    });

    function handleLoginResponse(request) {
        signHlp.innerText = request.responseText;
        if (request.status !== 200) {
            signHlp.className = "help is-danger";
        } else {
            signHlp.className = "help is-success";
        }
    }
};
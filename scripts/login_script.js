window.onload = function () {
  let loginBtn = document.querySelector('button');
  let loginHlp = document.getElementsByClassName('help')[0];

  loginBtn.addEventListener('click', function f() {
        let formData = new FormData(document.querySelector('form'));
        dataRequest(formData, handleLoginResponse, "login");
    });

  document.querySelector('form').addEventListener('submit', function (event) {
      event.preventDefault();
  });

    function handleLoginResponse(request) {
        loginHlp.innerHTML = request.responseText;
        if (request.status !== 200) {
            loginHlp.className = "help is-danger";
        } else {
            loginHlp.className = "help is-success";
            location.reload();
        }
    }
};
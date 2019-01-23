window.onload = function () {

    let commentBtn = document.getElementById('commentBtn');
    let image = document.querySelector('div.card-image img');
    let text = document.getElementById("commentText");
    let deleteBtn = document.getElementById("deleteBtn");
    let commentArea = document.getElementsByTagName("article");
    let lastComment = commentArea[commentArea.length - 2];
    let cardContent = document.getElementsByClassName("card-content")[0];
    let commentHelper = document.getElementById("commentHelper");

    commentBtn.addEventListener("click", function() {
        if (text.value.length < 351 && text.value.length > 0) {
            let formData = new FormData();
            formData.append("image", image.id);
            formData.append("txt", text.value);
            text.value = null;
            dataRequest(formData, handleCommentResponse, "comment");
        } else {
            commentHelper.className = "help is-danger";
            text.className = "textarea is-danger";
            if (text.value.length > 0) {
                commentHelper.innerText = "Comment is too long";
            } else {
                commentHelper.innerText = "Comment has empty body";
            }
        }
    });

    deleteBtn.addEventListener("click", function() {
        if (confirm("Are you sure about that?")) {
            let formData = new FormData();
            formData.append("image", image.id);
            dataRequest(formData, displayRequest, "delete");
        }
    });

    function handleCommentResponse(request) {
        if (request.status !== 200) {
            commentHelper.innerText = request.responseText;
            commentHelper.className = "help is-danger";
            text.className = "textarea is-danger";
        } else {
            let response = JSON.parse(request.responseText);
            let newComm = lastComment.cloneNode(true);
            let username = newComm.querySelector('strong');
            let commenttext = newComm.querySelector('br');
            username.innerHTML = response[0];
            commenttext.innerHTML = response[1];
            cardContent.insertBefore(newComm, cardContent.lastElementChild);
        }
    }
};


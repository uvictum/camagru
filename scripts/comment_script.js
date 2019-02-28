window.onload = function () {
    let commentBtn = document.getElementById('commentBtn');
    let deleteCmnt = document.querySelectorAll('a.link');
    let image = document.querySelector('div.card-image img');
    let text = document.getElementById("commentText");
    let deleteBtn = document.getElementById("deleteBtn");
    let cardContent = document.querySelector(".card-content");
    let commentHelper = document.getElementById("commentHelper");

    if (commentBtn) {
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
    }

    if (deleteCmnt) {
        deleteCmnt.forEach(function (elem) {
            elem.addEventListener('click', deleteComment)
        });
    }

    if (deleteBtn) {
        deleteBtn.addEventListener("click", function() {
            if (confirm("Are you sure about that?")) {
                let formData = new FormData();
                formData.append("image", image.id);
                dataRequest(formData, displayRequest, "delete");
            }
        });
    }

    function deleteComment() {
        if (confirm("Are you sure about that?")) {
            let formData = new FormData();
            formData.append("image", image.id);
            formData.append("ID", this.id);
            dataRequest(formData, handleCommentDeletion, "delete_comment");
        }
    }

    function handleCommentResponse(request) {
        if (request.status !== 200) {
            commentHelper.innerText = request.responseText;
            commentHelper.className = "help is-danger";
            text.className = "textarea is-danger";
        } else {
            let newComm = document.createElement('div');
            newComm.innerHTML = request.responseText;
            let comment = cardContent.insertBefore(newComm.firstChild, cardContent.lastElementChild);
            comment.querySelector('.link').addEventListener('click', deleteComment);
        }
    }

    function handleCommentDeletion(request) {
        if (request.status !== 200) {
            alert(request.responseText + 'Comment was not deleted');
        } else {
            let commentDeleted = document.querySelector('article#comment_' + request.responseText + '.media');
            commentDeleted.parentNode.removeChild(commentDeleted);
            alert('Comment was deleted');
        }
    }
};


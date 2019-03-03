
    let likeBtns = Array.from(document.getElementsByClassName('like_symbol'));
    let likedBtns = Array.from(document.getElementsByClassName('liked_symbol'));

    function likeFunc () {
        let formData = new FormData();
        formData.append("image", this.id.substr(4));
        dataRequest(formData, handleLikeResponse, "like");
    }

    function unlikeFunc () {
        let formData = new FormData();
        formData.append("image", this.id.substr(4));
        dataRequest(formData, handleLikeResponse, "unlike");
    }

    function handleLikeResponse(request) {
        if (request.status !== 200) {
            alert('Problem has occured' + request.responseText);
        } else {
            let res = JSON.parse(request.responseText);
            let like = document.getElementById('img_' + res.img);

            if (res.op == 1) {
                like.innerHTML = '<use xlink:href="#heart" />';
                like.className = 'icon liked_symbol';
                like.removeEventListener('click', likeFunc);
                like.addEventListener("click", unlikeFunc);
            } else if(res.op == 2) {
                like.innerHTML = '<use xlink:href="#heart-1" />';
                like.className = 'icon like_symbol';
                like.removeEventListener('click', unlikeFunc);
                like.addEventListener('click', likeFunc);
            }
        }
    }

    function checkLogged(request) {
        if (likeBtns && request.status === 200) {
            likeBtns.forEach(function (elem) {
                elem.addEventListener("click", likeFunc);
            })
        }
        if (likedBtns && request.status === 200) {
            likedBtns.forEach(function (elem) {
                elem.addEventListener("click", unlikeFunc)
            })
        }
    }

    dataRequest('', checkLogged, 'auth');




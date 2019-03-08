window.onload = function () {
    let containerElem = document.getElementsByClassName('container')[0];
    let containerBottom = containerElem.getBoundingClientRect().bottom + window.pageYOffset;
    var offset = 0;
    var limit = 5;
    var stop = 0;

    window.onscroll = function() {
        if (document.body.scrollHeight - window.pageYOffset === window.innerHeight && stop < 1) {
            stop = 1;
            let formData = new FormData();
            offset += limit;
            limit = 3;
            formData.append('limitLower', offset.toString());
            formData.append('limitUpper', limit.toString());
            dataRequest(formData, handleGalleryResponse, '');
        }
    };

    function handleGalleryResponse(request) {
        if (request.status !== 200) {
            stop = 1;
        } else {
            containerElem.innerHTML = containerElem.innerHTML + request.responseText;
            containerBottom = containerElem.getBoundingClientRect().bottom + window.pageYOffset;
            likeBtns = Array.from(document.getElementsByClassName('like_symbol'));
            likedBtns = Array.from(document.getElementsByClassName('liked_symbol'));
            dataRequest('', checkLogged, 'auth');
            stop = 0;
        }
    }
};
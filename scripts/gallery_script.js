window.onload = function () {
    let containerElem = document.getElementsByClassName('container')[0];
    let containerBottom = containerElem.getBoundingClientRect().bottom + window.pageYOffset;
    var limitLower = 0;
    var limitUpper = 6;
    var stop = 0;

    window.onscroll = function() {
        if (window.pageYOffset > containerBottom && stop < 1) {
            stop = 1;
            let formData = new FormData();
            limitLower = limitUpper;
            limitUpper += 6;
            formData.append('limitLower', limitLower.toString());
            formData.append('limitUpper', limitUpper.toString());
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
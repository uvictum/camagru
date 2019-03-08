window.onload = function () {
    let video = document.getElementById('video');
    let canvas = document.getElementById('canvas');
    let context = canvas.getContext('2d');
    let maskCanv = document.getElementById('viewport');
    let contextMask = maskCanv.getContext('2d');
    let mask = new Image();
    let masks = Array.from(document.getElementsByClassName("masksPng"));

    let upldBtn = document.getElementById("uploadPhoto");
    let snpBtn = document.getElementById("snap");
    let rtkBtn = document.getElementById("retakePhoto");
    let prevBtn = document.getElementById("preview");
    let chngSrcBtn = document.getElementById("changeSource");

    let fileInput = document.querySelector('input[type=file]');
    let fileForm = document.getElementById('fileInput');
    let finalImage;

    chngSrcBtn.source = true;
    chngSrcBtn.addEventListener("click", changeSource);
    masks.forEach(function(element) {
        element.addEventListener("click", placeMask);
    });
    snpBtn.addEventListener("click", function() {
        if (video.disabled !== true) {
            context.drawImage(video, 0, 0, 640, 480);
        }
        finalImage = convertCanvasToImage(canvas, video);
        swapObjDisplay(snpBtn, upldBtn);
        snpBtn.disabled = true;
        rtkBtn.style.display = "inline-block";
        chngSrcBtn.disabled = true;
        masks.forEach(function(element) {
            element.disabled =true;
        });
    });
    rtkBtn.addEventListener("click", function () {
        swapObjDisplay(upldBtn, snpBtn);
        snpBtn.disabled = false;
        if (video.disabled !== true) {
            swapObjDisplay(canvas, video);
            masks.forEach(function(element) {
                element.disabled =false;
            });
        } else {
            canvas.style.display = 'none';
            fileForm.style.display = 'flex';
            maskCanv.style.display = 'none';
        }
        rtkBtn.style.display = "none";
        chngSrcBtn.disabled =false;
    });
    upldBtn.addEventListener("click", function() {
        let formData = new FormData();
        let image = new Image();

        image.src = canvas.toDataURL("image/png");
        mask.src = maskCanv.toDataURL("image/png");
        formData.append("image", image.src);
        formData.append("mask", mask.src);
        dataRequest(formData, displayRequest, "editor");
        swapObjDisplay(upldBtn, snpBtn);
        snpBtn.disabled = false;
        if (video.disabled !== true) {
            swapObjDisplay(canvas, video);
        }
        rtkBtn.style.display = 'none';
        chngSrcBtn.disabled = false;
        masks.forEach(function(element) {
            element.disabled =false;
        });
    });
    prevBtn.addEventListener('click', previewFile);

    getVideo();

    function changeSource() {
        contextMask.clearRect(0,0, maskCanv.width, maskCanv.height);
        maskCanv.style.display = 'none';
        snpBtn.disabled = true;
        this.source = this.source !== true;
        if (this.source) {
            getVideo();
        } else {
            disableVideo();
        }
    }

    function disableVideo() {
        masks.forEach(function(element) {
            element.disabled =true;
        });
        video.disabled = true;
        video.pause();
        video.srcObject = null;
        video.style.display = 'none';
        fileForm.style.display ='flex';
        prevBtn.style.display = 'inline-block';
    }

    function getVideo() {
        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true, audio: false }).then(function(stream) {
                video.srcObject = stream;
                video.disabled = false;
                swapObjDisplay(fileForm, video);
                context.clearRect(0, 0, canvas.width, canvas.height);
                canvas.style.display = 'none';
                prevBtn.style.display = 'none';
                video.play();
                masks.forEach(function(element) {
                    element.disabled =false;
                });
            }).catch(disableVideo);
        }
    }

    function checkFile(file) {
        if (typeof file !== 'undefined' && file.size < 3000000) {
            switch (file.type) {
                case 'image/jpeg':
                case 'image/gif':
                case 'image/png':
                    return true;
            }
            return false;
        }
        return false;
    }

    function previewFile() {
        let file = fileInput.files[0];
        let reader  = new FileReader();
        let uploadImg = new Image();

        reader.onloadend = function () {
            uploadImg.src = reader.result;
            uploadImg.onload = function () {
                let sx = ((uploadImg.width) / 2) - 320; // get center coordinates to place crop rectangle in image center.
                let sy = ((uploadImg.height) / 2) - 240;
                context.drawImage(uploadImg, sx, sy, 640, 480, 0, 0, 640, 480);
            };
            swapObjDisplay(fileForm, canvas);
            masks.forEach(function(element) {
                element.disabled =false;
            });
        };
        if (checkFile(file)) {
            reader.readAsDataURL(file);
        } else {
            alert('Wrong file');
        }
    }

    function convertCanvasToImage(canvas, video) {
        swapObjDisplay(video, canvas);
    }

    function placeMask() {
        currentX = maskCanv.width/2;
        currentY = maskCanv.height/2;

        contextMask.clearRect(0, 0, canvas.width, canvas.height);
        mask.src = this.nextElementSibling.src;
        contextMask.drawImage(mask, currentX-(mask.width/2), currentY-(mask.height/2));
        mask.onload = function() {
            dragMask();
        };
        maskCanv.style.display ='inline-block';
        snpBtn.disabled = false;
    }

    function dragMask() {
        getMousePos();
        setInterval(function() {
            resetMaskCanv();
            drawMaskPos();
        }, 1000/30);
    }

    function drawMaskPos() {
        contextMask.drawImage(mask, currentX-(mask.width/2), currentY-(mask.height/2));
    }

    function resetMaskCanv() {
        contextMask.clearRect(0, 0, canvas.width, canvas.height);
    }

    function getMousePos() {
        let isDraggable;

        maskCanv.onmousedown = function (e) {
            let mouseX = e.pageX - this.getBoundingClientRect().left;
            let mouseY = e.pageY - this.getBoundingClientRect().top;

            if (mouseX >= (currentX - mask.width / 2) &&
                mouseX <= (currentX + mask.width / 2) &&
                mouseY >= (currentY - mask.height / 2) &&
                mouseY <= (currentY + mask.height / 2) &&
                snpBtn.disabled === false) {
                isDraggable = true;
            }
        };

        maskCanv.onmouseup = function (e) {
            isDraggable = false;
        };

        maskCanv.onmouseout = function (e) {
            isDraggable = false;
        };

        maskCanv.onmousemove = function (e) {
            if (isDraggable) {
                currentX = e.pageX - this.getBoundingClientRect().left;
                currentY = e.pageY - this.getBoundingClientRect().top;
            }
        };
    }
};

function swapObjDisplay(obj1, obj2) {
    obj1.style.display = "none";
    obj2.style.display = "inline-block";
}


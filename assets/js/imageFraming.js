var i = 0;
var video = document.createElement("video");
var thumbs = document.getElementById("thumbs");

video.addEventListener('loadeddata', function() {
    thumbs.innerHTML = "";
    video.currentTime = i;
}, false);

video.addEventListener('seeked', function() {
    // now video has seeked and current frames will show
    // at the time as we expect
    var dataURL = generateThumbnail();
    storeImage(i*2, dataURL);

    // when frame is captured, increase
    i=i+0.5;
    // if we are not passed end, seek to next interval
    if (i <= video.duration) {
        // this will trigger another seeked event
        video.currentTime = i;
    } else {
        // DONE!, next action
        alert(i * 2 + " images are created!");
    }
}, false);

video.preload = "auto";
video.src = base_url + "/assets/trailer.mp4";

function generateThumbnail() {
    var canvas = document.createElement("canvas");
    var context = canvas.getContext("2d");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
    thumbs.appendChild(canvas);

    var dataURL = canvas.toDataURL();
    return dataURL;
}

function storeImage(i, dataURL) {
    $.ajax({
        type: "POST",
        url: base_url + "home/upload",
        data: { data : dataURL, id : i },
        success: function(data) {
            // console.log(data); 
        }
    });
}
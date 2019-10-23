(function()
{
    var video = document.getElementById('video'),
    //draw the current video stream in the browser to the canvas
    canvas = document.getElementById('canvas'),
    context = canvas.getContext('2d'),
    vendorURL = window.URL || window.webkitURL;
//called to define whether we want video, audio
//if thyere is a success or error call back see if 
//the user denied the video being played 

    navigator.getMedia = navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia;

// use get media from navigator to capture video
    navigator.getMedia
        ({
            video: true,
            audio: false
        },
    function(stream)//success callback, gives webcam stream
        {   
            //video will hhave a source attribute with the 
            //stream URL
            video.srcObject=stream;
            video.play();
        },
    function()
        {
            //error code
        });
            //addEventListener attaches an event handler to the document 
            //adding a click event to the document
            document.getElementById('capture').addEventListener('click', function()
             {
        //draws the image onto the canvas
        //can draw parts of an image, and increase/reduce the image size
       
                 context.drawImage(video, 0, 0, 400, 300);
        
        //when you click you draw to the canvas and grabbing the DataURL
        //from the convas as a png replacing into the src attribute on the photo
        
        //photo.setAttribute('src', canvas.toDataURL(image/png));
    })
 }) ();
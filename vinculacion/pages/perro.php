<head>
    <link href="http://vjs.zencdn.net/5.10.4/video-js.css" rel="stylesheet">
    <link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>

</head>

<body>
<div id="video" title="tutorial" style="padding: 0 0 0 0;height: 350px">


<video style="visibility: hidden" id="my-video" class="video-js" controls preload="auto" width="700" height="400"
       poster="MY_VIDEO_POSTER.jpg" data-setup="{  }">
    <source src="http://127.0.0.1/vinculacion/pages/Carta.mp4" type='video/mp4'>

    <p class="vjs-no-js">
        To view this video please enable JavaScript, and consider upgrading to a web browser that
        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
</video>

</div>
<script src="http://vjs.zencdn.net/5.10.4/video.js"></script>


</body>

<script>
    $(document).ready(function(){




    dialogAseguradora= $("#video").dialog ({
        autoOpen : true,
        height: 450,
        width: 700,
        modal:true,
        resizable: false,
        title:false,
        close: function() {
                  },
        open: function( event, ui ) {
           // mostrarAseguradora();
        }
    });
        document.getElementById('my-video').style.visibility ='visible';
        console.warn('jalo');

        $(".ui-dialog-titlebar").hide();
        console.warn(dialogAseguradora);
        videojs('my-video').ready(function() {
            var player = this;
            player.play();

            player.on('ended', function() {
                console.warn('diii');
                $("#video").hide();
            });

        });
//        dialogAseguradora.show();
    });
</script>
<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 6/26/2016
 * Time: 2:46 PM
 */
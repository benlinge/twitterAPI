/* BUYING NOW PANEL*/
/* Image Pile One */
function rotateImagesOne(){
    //Returns first image and next sibling
    var $active = $('.lineOne .active');
    var $next = ($active.next().length > 0) ? $active.next() : $('.lineOne a:first');

    //Move the sibling to up One place
    $next.css('z-index',2);

    //First image fades out with speed parameter of 1.5 seconds
    $active.fadeOut(1500,function(){
        $active.css('z-index',1).show().removeClass('active');//Set z-index and unhide image
        $next.css('z-index',3).addClass('active');//make Sibling the Top image
    });
}
//Function called onload and loops every 5 seconds
$(document).ready(function(){
    setInterval('rotateImagesOne()', 5000);
})

/* Image Pile Two */
function rotateImagesTwo(){
    var $active = $('.lineTwo .active');
    var $next = ($active.next().length > 0) ? $active.next() : $('.lineTwo a:first');
    $next.css('z-index',2);
    $active.fadeOut(1500,function(){
        $active.css('z-index',1).show().removeClass('active');
        $next.css('z-index',3).addClass('active');
    });
}
$(document).ready(function(){
    setInterval('rotateImagesTwo()', 5000);
})

/* Image Pile Three */
function rotateImagesThree(){
    var $active = $('.lineThree .active');
    var $next = ($active.next().length > 0) ? $active.next() : $('.lineThree a:first');
    $next.css('z-index',2);
    $active.fadeOut(1500,function(){
        $active.css('z-index',1).show().removeClass('active');
        $next.css('z-index',3).addClass('active');
    });
}
$(document).ready(function(){
    setInterval('rotateImagesThree()', 5000);
})

/* Image Pile Four */
function rotateImagesFour(){
    var $active = $('.lineFour .active');
    var $next = ($active.next().length > 0) ? $active.next() : $('.lineFour a:first');
    $next.css('z-index',2);
    $active.fadeOut(1500,function(){
        $active.css('z-index',1).show().removeClass('active');
        $next.css('z-index',3).addClass('active');
    });
}
$(document).ready(function(){
    setInterval('rotateImagesFour()', 5000);
})

/* TWEET LIST */
//Function called on-click
function showTweetList(x){
    //Returns element defined within on-click button with ID and sets maximum height to 280px
    var panel = document.getElementById(x), maxHeight="280px";

    //If statement to decide to show or hide list
    if(panel.style.height == maxHeight){
        panel.style.height = "0px";//Hides list
    } else {
        panel.style.height = maxHeight;//Shows list
    }
}
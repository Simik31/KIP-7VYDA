function waitAndHideAlert() {
    setTimeout( function() {
        $("#success").fadeOut("slow", function(){
            $(this).replaceWith("<div class=\"alert placeholder\"></div>");
            $("#success").fadeIn("slow");
        });
        $("#error").fadeOut("slow", function(){
            $(this).replaceWith("<div class=\"alert placeholder\"></div>");
            $("#error").fadeIn("slow");
        });
    }, 2250);
}
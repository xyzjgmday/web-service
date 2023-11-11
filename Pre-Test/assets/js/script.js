window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
    });
}, 3000);
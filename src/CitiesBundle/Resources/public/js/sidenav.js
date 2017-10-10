$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass(function(state){
        $('#menu-toggle').hide();
        return "toggled";
    });
});

$('#menu-hide').click(function(e){
    e.preventDefault();
    $("#wrapper").toggleClass(function(state){
        $('#menu-toggle').show();
        return "toggled";
    });
});
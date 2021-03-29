$(document).ready(function(){

    $('#demo-carousel-auto').carousel({fullWidth: true});
    $('.linkCarousel').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.carousel').carousel('DECOUVRIR')
    });

    setInterval(function() {

        $('#demo-carousel-auto').carousel('next');

    }, 5000);

    $('.share-btn').click(function (e) {
        var win = window.open('boutique.php', '_self');
        win.focus();
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, options);
});

// Or with jQuery

$(document).ready(function(){
    $('select').formSelect();
});

//Page boutique select
    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, options);
});

    // Or with jQuery

    $(document).ready(function(){
    $('select').formSelect();
});



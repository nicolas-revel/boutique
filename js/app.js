(function($){
    $('.addPanier').click(function(event){
        event.preventDefault();
        $.get($(this).attr('href'),{},function(data){
            if(data.error){
                alert(data.message);
            }else {
                alert("Votre produit à bien été mis dans le panier");
            }
        },'json');
        return false;
    })
})(jQuery);
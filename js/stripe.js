window.onload = () => {
    //Variables
    let stripe = Stripe('pk_test_51INyY2KomI1Ouv8dsMAHwgTOui4gDFssmm2ob5MKuc59d5N2r3iaavrFH1R6bGzmtKm6GzYhkjQfmG9igxHJUt2i00KtI5eLjL')
    let elements = stripe.elements()
    let redirect = "panier.php?command=validation"

    //objet de la page
    let cardHolderName = document.getElementById("cardholder_name")
    let cardButton = document.getElementById("card-button")
    let clientSecret = cardButton.dataset.secret;

    //Créer les éléments du formulaire de carte
    let card = elements.create("card")
    card.mount("#card-elements")

    //On gère la saisie des erreurs
    card.addEventListener("change", (event) => {
        let displayError = document.getElementById("card_errors")
        if(event.error){
            displayError.textContent = event.error.message;
        }else{
            displayError.textContent = "";
        }
    })

    //On gère le paiement
    cardButton.addEventListener("click", () => {
        stripe.handleCardPayment(
            clientSecret, card, {
                payment_method_data: {
                    billing_details: {name: cardHolderName.value}
                }
            }
        ).then((result) =>  {
            if(result.error){
                document.getElementById("errors").innerText = result.error.message
            }else {
                document.location.href = redirect
            }
        })
    })

}
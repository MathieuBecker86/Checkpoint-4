if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}

function ready() {
    var removeCartItemButtons = document.getElementsByClassName('btn-danger')
    for (var i = 0; i < removeCartItemButtons.length; i++) {
        var button = removeCartItemButtons[i]
        button.addEventListener('click', removeCartItem)
    }

    var quantityInputs = document.getElementsByClassName('cart-quantity-input')
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i]
        input.addEventListener('change', quantityChanged)
    }

    var addToCartButtons = document.getElementsByClassName('shop-item-button')
    for (var i = 0; i < addToCartButtons.length; i++) {
        var button = addToCartButtons[i]
        button.addEventListener('click', addToCartClicked)
    }

    document.getElementsByClassName('btn-purchase')[0].addEventListener('click', purchaseClicked)
}

function purchaseClicked() {
    var form = document.getElementById('form')
  
    form.addEventListener('submit', event =>{
        event.preventDefault()
        var cartItemContainer = document.getElementsByClassName('cart-items')[0]
    var cartRows = cartItemContainer.getElementsByClassName('cart-row')
    var total = 0
    var global = []
    for (var i = 0; i < cartRows.length; i++) {
        var cartRow = cartRows[i]
        var titleElement = cartRow.getElementsByClassName('cart-item-title')[0]
        var priceElement = cartRow.getElementsByClassName('cart-price')[0]
        var quantityElement = cartRow.getElementsByClassName('cart-quantity-input')[0]
        var priceprep = priceElement.innerText.replace('Prix: ', '')
        var price = parseFloat(priceprep.replace(' euros', ''))
        var quantity = quantityElement.value
        total = total + (price * quantity)
        var totalTtc = total + total/10
        var list = [titleElement.innerText, priceElement.innerText, "quantité: "+ quantityElement.value]        
        global.push(list)

        
}
    var recap = []
    recap= [global ,['Total HT: '+ total, 'Total TTC: ' + totalTtc]]
    var recapToJson = JSON.stringify(recap);
    console.log(recapToJson)
    var send = document.getElementById('jsonSending')
    send.innerHTML += recapToJson

    document.forms["form"].submit();
})
}


function removeCartItem(event) {
    var buttonClicked = event.target
    buttonClicked.parentElement.parentElement.remove()
    updateCartTotal()
}

function quantityChanged(event) {
    var input = event.target
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1
    }
    updateCartTotal()
}

function addToCartClicked(event) {
    var button = event.target
    var shopItem = button.parentElement.parentElement
    var title = shopItem.getElementsByClassName('shop-item-title')[0].innerText
    var price = shopItem.getElementsByClassName('shop-item-price')[0].innerText
    var imageSrc = shopItem.getElementsByClassName('shop-item-image')[0].src
    addItemToCart(title, price, imageSrc)
    updateCartTotal()
}

function addItemToCart(title, price, imageSrc) {
    var cartRow = document.createElement('div')
    cartRow.classList.add('cart-row')
    var cartItems = document.getElementsByClassName('cart-items')[0]
    var cartItemNames = cartItems.getElementsByClassName('cart-item-title')
    for (var i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].innerText == title) {
            alert('Ce produit est déja dans votre panier')
            return
        }
    }
    var cartRowContents = `
        <div class="cart-item cart-column">
            <img class="cart-item-image" src="${imageSrc}" width="100" height="100">
            <span class="cart-item-title">${title}</span>
        </div>
        <span class="cart-price cart-column">${price}</span>
        <div class="cart-quantity cart-column">
            <input class="cart-quantity-input" type="number" value="1">
            <button class="btn btn-danger" type="button">Supprimer</button>
        </div>`
    cartRow.innerHTML = cartRowContents
    cartItems.append(cartRow)
    cartRow.getElementsByClassName('btn-danger')[0].addEventListener('click', removeCartItem)
    cartRow.getElementsByClassName('cart-quantity-input')[0].addEventListener('change', quantityChanged)
}

function updateCartTotal() {
    var cartItemContainer = document.getElementsByClassName('cart-items')[0]
    var cartRows = cartItemContainer.getElementsByClassName('cart-row')
    var total = 0
    for (var i = 0; i < cartRows.length; i++) {
        var cartRow = cartRows[i]
        var priceElement = cartRow.getElementsByClassName('cart-price')[0]
        var quantityElement = cartRow.getElementsByClassName('cart-quantity-input')[0]
        var priceprep = priceElement.innerText.replace('Prix: ', '')
        var price = parseFloat(priceprep.replace(' euros', ''))
        var quantity = quantityElement.value
        total = total + (price * quantity)
        var totalTtc = total + total/10
        
        
    
}
    total = Math.round(total * 100) / 100
    totalTtc = Math.round(totalTtc * 100) / 100
    document.getElementsByClassName('cart-total-price')[0].innerText = total + ' euros'
    document.getElementsByClassName('cart-total-price-ttc')[0].innerText = totalTtc + ' euros'
    if(isNaN(totalTtc)){
        document.getElementsByClassName('cart-total-price-ttc')[0].innerText = 0 +' euros'

}
}

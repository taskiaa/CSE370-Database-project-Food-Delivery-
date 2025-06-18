$(document).ready(function () {
    // ************************************************
// Shopping Cart API
// ************************************************

    var shoppingCart = (function () {
        // =============================
        // Private methods and propeties
        // =============================
        cart = [];

        // Constructor
        function Item(id, name, price, count) {
            this.id = id;
            this.name = name;
            this.price = price;
            this.count = count;
        }


        // =============================
        // Public methods and propeties
        // =============================
        var obj = {};

        // Add to cart
        obj.addItemToCart = function (id, name, price, count) {
            for (var item in cart) {
                if (cart[item].id === id) {
                    cart[item].count++;
                    return;
                }
            }
            var item = new Item(id, name, price, count);
            cart.push(item);
        }
        // Set count from item
        obj.setCountForItem = function (id, count) {
            for (var i in cart) {
                if (cart[i].id === id) {
                    cart[i].count = count;
                    break;
                }
            }
        };
        // Remove item from cart
        obj.removeItemFromCart = function (id) {
            for (var item in cart) {
                if (cart[item].id === id) {
                    cart[item].count--;
                    if (cart[item].count === 0) {
                        cart.splice(item, 1);
                    }
                    break;
                }
            }
        }

        // Remove all items from cart
        obj.removeItemFromCartAll = function (id) {
            for (var item in cart) {
                if (cart[item].id === id) {
                    cart.splice(item, 1);
                    break;
                }
            }
        }

        // Clear cart
        obj.clearCart = function () {
            cart = [];
        }

        // Count cart
        obj.totalCount = function () {
            var totalCount = 0;
            for (var item in cart) {
                totalCount += cart[item].count;
            }
            return totalCount;
        }

        // Total cart
        obj.totalCart = function () {
            var totalCart = 0;
            for (var item in cart) {
                totalCart += cart[item].price * cart[item].count;
            }
            return Number(totalCart.toFixed(2));
        }

        // List cart
        obj.listCart = function () {
            var cartCopy = [];
            for (i in cart) {
                item = cart[i];
                itemCopy = {};
                for (p in item) {
                    itemCopy[p] = item[p];
                }
                itemCopy.total = Number(item.price * item.count).toFixed(2);
                cartCopy.push(itemCopy)
            }
            return cartCopy;
        }

        // cart : Array
        // Item : Object/Class
        // addItemToCart : Function
        // removeItemFromCart : Function
        // removeItemFromCartAll : Function
        // clearCart : Function
        // countCart : Function
        // totalCart : Function
        // listCart : Function
        return obj;
    })();


// *****************************************
// Triggers / Events
// *****************************************
// Add item
    $('.add-to-cart').click(function (event) {
        event.preventDefault();
        var id = Number($(this).data('id'));
        var name = $(this).data('name');
        var price = Number($(this).data('price'));
        shoppingCart.addItemToCart(id, name, price, 1);
        displayCart();
    });

// Clear items
    $('.clear-cart').click(function () {
        shoppingCart.clearCart();
        displayCart();
    });


    function displayCart() {
        var cartArray = shoppingCart.listCart();
        var output = "";
        for (var i in cartArray) {
            output += "<tr>"
                + "<td>" + cartArray[i].name + "</td>"
                + "<td>(" + cartArray[i].price + ")</td>"
                + "<td><div class='input-group'><button class='minus-item input-group-addon btn btn-primary' data-id=" + cartArray[i].id + ">-</button>"
                + "<input type='number' class='item-count form-control' data-id='" + cartArray[i].id + "' value='" + cartArray[i].count + "'>"
                + "<button class='plus-item btn btn-primary input-group-addon' data-id=" + cartArray[i].id + ">+</button></div></td>"
                + "<td><button class='delete-item btn btn-danger btn-sm' style='background-color: var(--bs-btn-bg)' data-id=" + cartArray[i].id + ">Remove</button></td>"
                + " = "
                + "<td>" + cartArray[i].total + "</td>"
                + "</tr>";
        }

        $('.show-cart').html(output);
        $('.total-cart').html(shoppingCart.totalCart());
        $('.total-count').html(shoppingCart.totalCount());

        if (cartArray.length === 0) {
            $('#order-btn').hide();
            $('#no-item-msg').show();
        } else {
            $('#order-btn').show();
            $('#no-item-msg').hide();
        }
    }

    // Delete item button
    $('.show-cart').on("click", ".delete-item", function (event) {
        var id = $(this).data('id')
        shoppingCart.removeItemFromCartAll(id);
        displayCart();
    })

    $('.open-cart').click(function (e) {
        $('#successMsg').hide();
        $('#errorMsg').hide();
    });

    // -1
    $('.show-cart').on("click", ".minus-item", function (event) {
        var id = $(this).data('id')
        shoppingCart.removeItemFromCart(id);
        displayCart();
    })
    // +1
    $('.show-cart').on("click", ".plus-item", function (event) {
        var id = $(this).data('id')
        shoppingCart.addItemToCart(id);
        displayCart();
    })

    // Item count input
    $('.show-cart').on("change", ".item-count", function (event) {
        var id = $(this).data('id');
        var count = Number($(this).val());
        shoppingCart.setCountForItem(id, count);
        displayCart();
    });

    $('#order-btn').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: './order-food.php',
            type: 'POST',
            data: JSON.stringify({
                foodList: shoppingCart.listCart(),
                restaurantId: restaurantId
            }),
            contentType: 'application/json', // this is what you want
            success: function(data, status, xhr) {
                data = JSON.parse(data);

                if (data.status === false) {
                    $('#errorMsg').show();
                    $('#successMsg').hide();
                } else if (data.status === true) {
                    shoppingCart.clearCart();
                    displayCart();
                    $('#errorMsg').hide();
                    $('#successMsg').show();
                }
            }
        });
    });

    $('#errorMsg').hide();
    $('#successMsg').hide();
    displayCart();
});
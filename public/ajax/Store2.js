const xmlhttp = new XMLHttpRequest();
$(document).ready(function () {

    clearSession();

    $('#filter').hide();
    $('#data-2').hide();

    $('#btn-check-2-outlined').click(function () {
        if ($('#btn-check-2-outlined').is(":checked")) {
            $('#filter').show();
        } else {
            $('#filter').hide();
        };

    })

    $('#milkFoamCheck').click(function () {

        if ($('#milkFoamCheck').is(":checked")) {
            milkFoamCheck = { 'id': 1, 'name': "Milk Foam", 'type': 'checked', 'keyName': 'milkFoam' };
            sendXML(milkFoamCheck);
        } else {
            milkFoamCheck = { 'id': 1, 'name': "Milk Foam", 'type': 'unChecked', 'keyName': 'milkFoam' };
            sendXML(milkFoamCheck);
        };

    });

    $('#whitePearlCheck').click(function () {

        if ($('#whitePearlCheck').is(":checked")) {
            whitePearCheck = { 'id': 2, 'name': "White Pearl", 'type': 'checked', 'keyName': 'whitePearl' };
            sendXML(whitePearCheck);
        } else {
            whitePearCheck = { 'id': 2, 'name': "White Pearl", 'type': 'unChecked', 'keyName': 'whitePearl' };
            sendXML(whitePearCheck);
        };

    });
    function clearSession() {
        $.ajax({
            type: "POST",
            url: '/clear-session',

            success: function (response) {
                console.log(response);
            }
        })
    }
    function sendXML(data) {
        $.ajax({
            type: "POST",
            url: '/store2/filter',
            data: data,
            success: function (response) {

                let products = response.dataFilter;
                let listTopping = response.listToppings;

                $('#data-1').hide();
                $('#data-2').show();
                if (products.length == 0) {
                    return document.getElementById("data-2").innerHTML = "No product";
                }
                document.getElementById("data-2").innerHTML = '';
                for (let i = 0; i < products.length; i++) {

                    document.getElementById("data-2").innerHTML +=  '<div class="col-3">' +
                    '<div class=" card border-primary mb-3 ml-5" style="height: 250px; max-width: 18rem;">' +
                    '<div class="card-header">' + products[i].name + '</div>' +
                    '<div class="card-body">' +
                    '<h5 class="card-title">Topping:</h5>' +
                    '<p id="toppings-card' + i + '" class="card-text" style="height: 100px;"> </p>' +
                    '<div class="row">' +
                    '<div class="col-6">Cost</div>' +
                    '<div id="product-price" class="col-6 d-flex flex-row-reverse">' + products[i].price + '</div>' +
                    '</div>' +
                    '</div >' +
                    '</div >' +
                    '</div >';

                    for (let j = 0; j < products[i].toppings.length; j++) {
                        let toppingResult = listTopping.find(res => res.id == products[i].toppings[j]);

                        if (j == 0) {
                            document.getElementById("toppings-card" + i).innerHTML += toppingResult.name;
                        } else {
                            document.getElementById("toppings-card" + i).innerHTML += ", " + toppingResult.name;
                        }
                    }
                }



            },
        })
    }

});


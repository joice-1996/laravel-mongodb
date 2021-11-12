var cartdata = [];
var sum = 0;
var product_xmlhttp = new XMLHttpRequest();

product_xmlhttp.onreadystatechange = function() {
    if (product_xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
        if (product_xmlhttp.status == 200) {
            product_data = JSON.parse(product_xmlhttp.responseText);

            //console.log(product_data);
        }
    }
};
var requestVariable = 'http://localhost/laravel_mongodb/public/get_product';
product_xmlhttp.open("GET", requestVariable, true);
product_xmlhttp.send();


//validate product
function validate_product() {
    var product_id = document.getElementById("product_id").value;
    if (product_id == "") {

        document.getElementById("productIdEr").innerHTML = "Select Product";
        return false;
    } else {
        document.getElementById("productIdEr").innerHTML = "";
        return false;
    }
}

//validate rate
function validate_rate() {
    console.log(1);
    var rate = document.getElementById("product_rate").value;
    var numReg1 = /[0-9.]$/;
    if (rate.trim() == "") {
        document.getElementById("rateEr").innerHTML = "Rate field is required";
        return false;
    } else if (rate == 0) {
        document.getElementById("rateEr").innerHTML = "Rate must be above 0";
        return false;
    } else if (!(numReg1.test(rate))) {
        document.getElementById("rateEr").innerHTML = "Rate must be numeric";
        return false;
    } else {
        document.getElementById("rateEr").innerHTML = "";
        return false;
    }
}

//validate quantity
function validate_quantity() {
    var numReg = /[0-9]$/;
    var quantity = document.getElementById("quantity").value;
    if (quantity.trim() == "") {
        document.getElementById("quantityEr").innerHTML = "Quantity Field is required";
        return false;
    } else if (quantity == 0) {
        document.getElementById("quantityEr").innerHTML = "Quantity must be above 0";
        return false;
    } else if (!numReg.test(quantity)) {
        document.getElementById("quantityEr").innerHTML = "Quantity must be numeric";
        return false;
    } else {
        document.getElementById("quantityEr").innerHTML = "";
        return false;
    }
}

//To get total rate
function get_total_rate() {
    var rate = document.getElementById('product_rate').value;
    var quantity = document.getElementById('quantity').value;
    var total_rate = rate * quantity;
    document.getElementById("total_rate").value = total_rate;
}

function user_name() {
    var user_id = document.getElementById("user_id").value;
    var user_xmlhttp = new XMLHttpRequest();
    user_xmlhttp.onreadystatechange = function() {
        if (user_xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (user_xmlhttp.status == 200) {
                resp = JSON.parse(user_xmlhttp.responseText);
                if (resp.name) {
                    document.getElementById("user").value = resp.name;
                    document.getElementById("user").style.display = '';
                    document.getElementById("user_id").style.display = 'none';
                    document.getElementById("useridEr").innerHTML = "";
                }
                //console.log(product_data);
            }
        }
    };
    var requestVariable = 'http://localhost/laravel_mongodb/public/get_user/' + user_id;
    user_xmlhttp.open("GET", requestVariable, true);
    user_xmlhttp.send();
}


//To add product to the cart
function productAddToCart() {
    var numReg1 = /[0-9.]$/;
    var numReg = /[0-9]$/;
    var user_id = document.getElementById("user_id").value;
    if (user_id == "") {
        document.getElementById("useridEr").innerHTML = "Select User";
        return false;
    }
    var product_id = document.getElementById("product_id").value;
    if (product_id == "") {

        document.getElementById("productIdEr").innerHTML = "Select Product";
        return false;
    }
    var rate = document.getElementById("product_rate").value;
    if (rate.trim() == "") {
        document.getElementById("rateEr").innerHTML = "Rate field is required";
        return false;
    }
    if (!(numReg1.test(rate))) {
        document.getElementById("rateEr").innerHTML = "Rate field must be numeric";
        return false;
    }
    if (rate.trim() == 0) {
        document.getElementById("rateEr").innerHTML = "Rate must be above 0";
        return false;
    }
    var quantity = document.getElementById("quantity").value;
    if (quantity.trim() == "") {
        document.getElementById("quantityEr").innerHTML = "Quantity Field is required";
        return false;
    }
    if (quantity == 0) {
        document.getElementById("quantityEr").innerHTML = "Quantity must be above 0";
        return false;
    }
    if (!numReg.test(quantity)) {
        document.getElementById("quantityEr").innerHTML = "Quantity must be numeric";
        return false;
    }

    var total_rate = document.getElementById("total_rate").value;

    document.getElementById("table1").style.display = "block";

    if ((product_id != null) && (product_id != '')) {

        //alert(1);

        var datas = {
            "product_id": product_id,
            "rate": rate,
            "quantity": quantity,
            "total_rate": total_rate,
        };
        cartdata.push(datas);
        console.log(cartdata);





        // Add product to Table
        productAddToTable();
        //cartdata.forEach(productAddToTable);

        $('select[name^="product_id"] option[value=' + product_id + ']').attr("disabled", "disabled");

        // Clear form fields
        formClear();

        //product_id.blur();

    }


}

function productAddToTable() {
    if ($("#productTable tbody").length == 0) {
        $("#productTable").append("<tbody></tbody>");
    }


    // Append product to the table
    var product_id1 = $("#product_id").val();
    console.log(product_id1);
    $("#productTable tbody").append("<tr id='" + product_id1 + "'>" +
        "<td>" + product_data[$("#product_id").val()] + "</td>" +
        "<td>" + $("#product_rate").val() + "</td>" +
        "<td>" + $("#quantity").val() + "</td>" +
        "<td>" + $("#total_rate").val() + "</td>" +
        "<td>" +
        "<button type='button' onclick='productDelete(&#039;" + product_id1 + "&#039;);' class='btn btn-default btn-primary'>" +
        "Delete" +
        "</button>" +
        "</td>" +
        "</tr>");
}

function formClear() {
    $("#product_id").val("");
    $("#product_rate").val("");
    $("#quantity").val("");
    $("#total_rate").val("");

}



function productDelete(ctl) {
    console.log(1);
    cartdata.splice(cartdata.findIndex(function(i) {
        return i.id === ctl;
    }), 1);
    console.log(cartdata);

    deleteFromCart(ctl);
    //$(ctl).parents("tr").remove();


}

function deleteFromCart(id) {
    var data = document.getElementById(id);
    data.parentNode.removeChild(data);
    //console.log("array");
    if (Array.isArray(cartdata) && cartdata.length == 0) {
        document.getElementById("table1").style.display = 'none';
    }

}

//To place the order
function order_now() {
    var user_id = document.getElementById("user_id").value;
    if (user_id == "") {
        document.getElementById("useridEr").innerHTML = "Select User";
        return false;
    }
    if (Array.isArray(cartdata) && cartdata.length == 0) {
        alert("add products to the cart")
    }


    var user_id = document.getElementById("user_id").value;
    //alert(cartdata);
    for (item of cartdata) {
        sum = sum + parseInt(item['total_rate']);
        document.getElementById("final_rate").value = sum;

    }
    var final_rate = document.getElementById("final_rate").value;


    var user = {
        'user_id': user_id,
        'final_rate': final_rate
    }

    var final_rate = document.getElementById("final_rate").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {

                var resp = xmlhttp.responseText.trim();

                if (resp == 'Success') {

                    document.getElementById("user_id").value = "";
                    document.getElementById("user").value = '';
                    document.getElementById("user").style.display = 'none';
                    document.getElementById("user_id").style.display = '';
                    document.getElementById("product_id").value = "";
                    document.getElementById("product_rate").value = "";
                    document.getElementById("quantity").value = "";
                    document.getElementById("total_rate").value = "";
                    document.getElementById("table1").style.display = 'none';
                    order_list();
                    alert("successfully inserted");
                } else {
                    var resp = JSON.parse(xmlhttp.responseText);
                    if (resp.user_id) {
                        document.getElementById("useridEr").innerHTML = resp.user_id[0];
                        return false;
                    }
                    if (resp.product_id) {
                        document.getElementById("productIdEr").innerHTML = resp.product_id[0];
                        return false;
                    }
                    if (resp.rate) {
                        document.getElementById("rateEr").innerHTML = resp.rate[0];
                        return false;
                    }
                    if (resp.quantity) {
                        document.getElementById("quantityEr").innerHTML = resp.quantity[0];
                        return false;
                    }
                }




            } else if (xmlhttp.status == 400) {
                alert('There was an error 400');
            } else {
                alert('something else other than 200 was returned');
            }
        }
    };
    var requestVariable = 'http://localhost/laravel_mongodb/public/order_now';
    xmlhttp.open("POST", requestVariable, true);
    var data = new FormData();
    data.append('user', JSON.stringify({ user }));
    data.append('_token', "{{csrf_token()}}");
    data.append('order_details', JSON.stringify({ cartdata }));
    xmlhttp.send(data);


}

function order_close() {
    document.getElementById("user_id").value = "";
    document.getElementById("user_id").style.display = '';
    document.getElementById("user").value = "";
    document.getElementById("user").style.display = 'none';
    document.getElementById("table1").style.display = 'none';
    document.getElementById("product_id").value = "";
    document.getElementById("product_rate").value = "";
    document.getElementById("quantity").value = "";
    document.getElementById("total_rate").value = "";
    location.reload();

}



//update view

function update_view(id) {
    console.log(1);
    var user_xmlhttp = new XMLHttpRequest();
    user_xmlhttp.onreadystatechange = function() {
        if (user_xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (user_xmlhttp.status == 200) {
                resp = JSON.parse(user_xmlhttp.responseText);
                //console.log(resp.users);
                console.log(resp.users['name']);
                document.getElementById("user_edit_id").value = resp.users['name'];
                document.getElementById("order_id").value = resp._id;
                var str = "<table id='productTable2' class='table table-bordered table-condensed table-striped'>"
                str += "<thead>"
                str += "<tr>"
                str += "<th>Product Name</th>"
                str += "<th>Rate</th>"
                str += "<th>Quantiy</th>"
                str += "<th>Action</th>"
                str += " </tr>"
                str += "</thead>"
                str += "<tbody>"

                for (var item1 of resp.order_details) {

                    str += "<tr id=&#039; " + item1['_id'] + "&#039;> "
                    str += " <td > " + item1['products']['product_name'] + "</td>"
                    str += "<td>" + item1['rate'] + "</td>"
                    str += "<td>" + item1['quantity'] + "</td>"
                    str += "<td>" + "<button type='button' onclick='productDeletee(&#039;" + item1['_id'] + "&#039;);' class='btn btn-default btn-primary'>"
                    str += "Delete" + "</button>" + "</td>"

                }
                str += "</tbody>"
                "</table>"
                //console.log(str);

                document.getElementById('table_data').innerHTML = str;
                //document.getElementById("final_edit_rate").value = resp.total_rate;


            }
        }
    };
    var requestVariable = 'http://localhost/laravel_mongodb/public/get_order/' + id;
    user_xmlhttp.open("GET", requestVariable, true);
    user_xmlhttp.send();

}

function productDeletee(id) {
    var confirm2 = confirm("Are you sure want to delete this product");
    if (confirm2) {} else {
        cancel();
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                resp = xmlhttp.responseText;
                if (resp.trim() == "success") {
                    update_view(id);
                }

                //console.log(product_data);
            }
        }
    };
    var requestVariable = 'http://localhost/laravel_mongodb/public/product_delete/' + id;
    xmlhttp.open("GET", requestVariable, true);
    xmlhttp.send();
}


function productdelete_fromcart(id) {
    var data = document.getElementById(id);
    data.parentNode.removeChild(data);
}

//add new

function addnewcart() {

    document.getElementById("addnewcart").style.display = '';
    //document.getElementById("addnew").style.display = 'none';

}

function update_order_close() {
    document.getElementById("addnewcart").style.display = 'none';
}



//validate product
function validate_product_edit() {
    var product_id = document.getElementById("product_edit_id").value;
    if (product_id == "") {

        document.getElementById("product_editIdEr").innerHTML = "Select Product";
        return false;
    } else {
        document.getElementById("product_editIdEr").innerHTML = "";
        return false;
    }
}

//validate rate
function validate_edit_rate() {
    var rate = document.getElementById("product_edit_rate").value;
    var numReg = /[0-9.]/;
    if (rate.trim() == "") {
        document.getElementById("rate_editEr").innerHTML = "Rate field is required";
        return false;
    } else if (rate == 0) {
        document.getElementById("rate_editEr").innerHTML = "Rate must be above 0";
        return false;
    } else if (!(numReg.test(rate))) {
        document.getElementById("rate_editEr").innerHTML = "Rate must be numeric";
        return false;
    } else {
        document.getElementById("rate_editEr").innerHTML = "";
        return false;
    }
}

//validate quantity
function validate_edit_quantity() {
    var numReg = /[0-9]$/;
    var quantity = document.getElementById("edit_quantity").value;
    if (quantity.trim() == "") {
        document.getElementById("quantity_editEr").innerHTML = "Quantity Field is required";
        return false;
    } else if (quantity == 0) {
        document.getElementById("quantity_editEr").innerHTML = "Quantity must be above 0";
        return false;
    } else if (!numReg.test(quantity)) {
        document.getElementById("quantity_editEr").innerHTML = "Quantity must be numeric";
        return false;
    } else {
        document.getElementById("quantity_editEr").innerHTML = "";
        return false;
    }
}


function get_total_edit_rate() {
    var rate = document.getElementById('product_edit_rate').value;
    var quantity = document.getElementById('edit_quantity').value;
    var total_rate = rate * quantity;
    document.getElementById("total_edit_rate").value = total_rate;
}




//To add product to the cart
function UpdateCart() {
    var numReg1 = /[0-9.]$/;
    var numReg = /[0-9]$/;
    var user_id = document.getElementById("user_edit_id").value;
    var order_id = document.getElementById("order_id").value;
    var product_id = document.getElementById("product_edit_id").value;
    if (product_id == "") {

        document.getElementById("productIdEr").innerHTML = "Select Product";
        return false;
    }
    var rate = document.getElementById("product_edit_rate").value;
    if (rate.trim() == "") {
        document.getElementById("rate_editEr").innerHTML = "Rate field is required";
        return false;
    }
    if (!(numReg1.test(rate))) {
        document.getElementById("rate_editEr").innerHTML = "Rate field must be numeric";
        return false;
    }
    if (rate.trim() == 0) {
        document.getElementById("rate_editEr").innerHTML = "Rate must be above 0";
        return false;
    }
    var quantity = document.getElementById("edit_quantity").value;
    if (quantity.trim() == "") {
        document.getElementById("quantity_editEr").innerHTML = "Quantity Field is required";
        return false;
    }
    if (quantity == 0) {
        document.getElementById("quantity_editEr").innerHTML = "Quantity must be above 0";
        return false;
    }
    if (!numReg.test(quantity)) {
        document.getElementById("quantity_editEr").innerHTML = "Quantity must be numeric";
        return false;
    }
    var total_rate = document.getElementById("total_edit_rate").value;
    if (total_rate == "") {
        document.getElementById("totalrate_editEr").innerHTML = "Total rate is required";
    }
    //document.getElementById("table2").style.display = "block";

    if ((product_id != null) && (product_id != '')) {

        //alert(1);

        var new_order = {
            "order_id": order_id,
            "user_id": user_id,
            "product_id": product_id,
            "rate": rate,
            "quantity": quantity,
            "total_rate": total_rate,
        };
        /* cartdata.push(datas);
        console.log(cartdata); */
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {

                var resp = xmlhttp.responseText.trim();

                if (resp == 'success') {
                    document.getElementById("addnewcart").style.display = 'none';
                    document.getElementById("error").innerHTML = "";
                    update_view(order_id);

                } else if (resp == 'exist') {
                    document.getElementById("error").innerHTML = "Already Selected";
                } else {
                    var resp = JSON.parse(xmlhttp.responseText);
                    if (resp.product_id) {
                        document.getElementById("productIdEr").innerHTML = resp.product_id[0];
                        return false;
                    }
                    if (resp.rate) {
                        document.getElementById("rateEr").innerHTML = resp.rate[0];
                        return false;
                    }
                    if (resp.quantity) {
                        document.getElementById("quantityEr").innerHTML = resp.quantity[0];
                        return false;
                    }
                }




            } else if (xmlhttp.status == 400) {
                alert('There was an error 400');
            } else {
                alert('something else other than 200 was returned');
            }
        }
    };
    var requestVariable = 'http://localhost/laravel_mongodb/public/add_new_order';
    xmlhttp.open("POST", requestVariable, true);
    var data = new FormData();
    data.append('_token', "{{csrf_token()}}");
    data.append('order_details', JSON.stringify({ new_order }));
    xmlhttp.send(data);
}

//order delete
function delete_order(id) {

    var confirm1 = confirm("Are you sure want to delete this order");
    if (confirm1) {} else {
        cancel();
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                resp = xmlhttp.responseText;
                if (resp.trim() == "success") {
                    order_list();
                }

                //console.log(product_data);
            }
        }
    };
    var requestVariable = 'http://localhost/laravel_mongodb/public/order_delete/' + id;
    xmlhttp.open("GET", requestVariable, true);
    xmlhttp.send();
}

//order list
function order_list() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                resp = xmlhttp.responseText;
                document.getElementById("myDiv").innerHTML = resp;

                //console.log(product_data);
            }
        }
    };
    var requestVariable = 'http://localhost/laravel_mongodb/public/order';
    xmlhttp.open("GET", requestVariable, true);
    xmlhttp.send();
}

function save() {
    order_list();
}
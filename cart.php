<?php
    // Start session
    session_start();
    
    // Delete shopping cart item
    if (isset($_GET["del"])) {
        unset($_SESSION["shopping_cart"][$_GET["del"]]);
        // Prompt user that the item was removed from the cart
        echo '<script>alert("Item successfully removed from the cart.");</script>';

    }

    // Count shopping cart items
    $cartcount = $subtotal = $total = 0;
    $dis = $arr = $hide = "";

    if (isset($_SESSION["shopping_cart"]) && count($_SESSION["shopping_cart"]) != 0) {
        $cartcount = count($_SESSION["shopping_cart"]);
        foreach ($_SESSION["shopping_cart"] as $key => $var) {
            $subtotal = intval($var['qty']) * intval($var['price']);
            $total += $subtotal;
            $arr .= "<tr>".
                        '<td><img src="img/burger-hero1.png" class="img-cart" alt=""></td>'.
                        "<td>".
                            $var['name'].
                            '<input type="hidden" name="txtName[]" value="'.$var["name"].'">'.
                        '</td>'.
                        "<td>".
                            "Bun: ".$var["bun"].'<input type="hidden" name="txtBun[]" value="'.$var["bun"].'"><br><br>'.
                            "Meat: ".$var["meat"].'<input type="hidden" name="txtMeat[]" value="'.$var["meat"].'"><br><br>'.
                            "Toppings: ".$var["toppings"].'<input type="hidden" name="txtToppings[]" value="'.$var["toppings"].'">'.
                        '</td>'.
                        "<td>".
                            $var['price'].
                            '<input type="hidden" name="txtPrice[]" id="txtPrice" value="'.$var["price"].'">'.
                        "</td>".
                        "<td>".
                            $var["qty"].
                            '<input type="hidden" name="txtQuantity[]"value="'.$var["qty"].'">'.
                        "</td>".
                        '<td class="txtright">'.
                            "<span>".$subtotal."</span>.00".
                            '<input type="hidden" name="txtSubtotal" value="'.$subtotal.'">'.
                        "</td>".
                        '<td><a href="cart.php?del='.$key.'" class="btnDelete">Remove</a></td>'.
                    "</tr>";
        }
        $arr .= '<tr class="nobotborder">'.
                    '<td colspan="5" class="txtright">Subtotal:</td>'.
                    '<td class="txtright">
                        '.$total.'.00
                        <input type="hidden" name="txtTotal" value="'.$total.'">
                    </td>'.
                    '<td></td>'.
                "</tr>".
                '<tr class="nobotborder">'.
                    '<td colspan="5" class="txtright">Delivery Fee:</td>'.
                    '<td class="txtright">
                        50.00
                        <input type="hidden" name="txtDelivery" value="50">
                    </td>'.
                    '<td></td>'.
                "</tr>".
                '<tr class="nobotborder">'.
                    '<td colspan="5" class="txtright"></td>'.
                    '<td class="txtright"><hr></td>'.
                    '<td></td>'.
                "</tr>".
                '<tr class="nobotborder">'.
                    '<td colspan="5" class="txtright"><h1>Total Amount To Be Paid:</h1></td>'.
                    '<td class="txtright">
                        <h1>&#8377;&nbsp;&nbsp;'.intval($total + 50).'.00</h1>
                        <input type="hidden" name="txtTotal" value="'.intval($total + 80).'">
                    </td>'.
                    '<td></td>'.
                "</tr>";
    } else {
        $dis = "disabled";
        $arr = '<td colspan="7" class="textCenter">
                    <h1 class="text-center">Cart is empty</h1>
                </td>';
        $hide = "hidden";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Own Burger</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="container">
        <section class="section-create">
            <div class="content-title">
                <div class="title-block">
                    <svg id="Layer_1" enable-background="new 0 0 512.101 512.101" height="500" width="500" viewBox="0 0 512.101 512.101" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="m327.884 0h-143.381c-91.801 0-168.109 67.601-181.752 155.639-.919 5.929 3.636 11.293 9.635 11.293h487.614c6 0 10.554-5.364 9.635-11.293-13.643-88.038-89.951-155.639-181.751-155.639zm-135.758 63.76c-6.635 6.635-17.393 6.635-24.028 0s-6.635-17.393 0-24.028 17.393-6.635 24.028 0c6.636 6.635 6.636 17.393 0 24.028zm76.461 58.645c-6.635 6.635-17.393 6.635-24.028 0s-6.635-17.393 0-24.028 17.393-6.635 24.028 0c6.636 6.635 6.636 17.393 0 24.028zm76.461-58.645c-6.635 6.635-17.393 6.635-24.029 0-6.635-6.635-6.635-17.393 0-24.028s17.393-6.635 24.029 0 6.636 17.393 0 24.028z"/>
                            <path d="m26.727 363.197v34.795h454.116v-34.795h-309.861c-11.447 9.404-25.665 14.515-40.679 14.515-15.369 0-29.511-5.448-40.591-14.515z"/>
                            <path d="m97.697 512.101h318.44c43.17 0 79.852-28.315 92.451-67.348 2.036-6.309-2.648-12.779-9.277-12.779h-484.787c-6.63 0-11.314 6.47-9.277 12.779 12.599 39.032 49.28 67.348 92.45 67.348z"/>
                            <path d="m31.258 233.07h29.256c21.617 0 39.277 17.586 39.368 39.202l.174 41.338c.07 16.608 13.639 30.12 30.247 30.12 8.104 0 15.715-3.163 21.433-8.905 5.718-5.741 8.847-13.367 8.813-21.47l-.17-40.753c-.045-10.545 4.029-20.47 11.47-27.943 7.442-7.474 17.35-11.59 27.897-11.59h281.097c.288 0 .571.018.858.022v-32.179h-454.974v32.333c1.499-.103 3.006-.175 4.531-.175z"/>
                            <path d="m480.843 329.215c17.139 0 31.082-13.943 31.082-31.082s-13.943-31.082-31.082-31.082h-281.097c-1.947 0-3.228.993-3.817 1.586-.59.592-1.577 1.876-1.569 3.822l.17 40.754c.023 5.468-.633 10.834-1.928 16.002z"/>
                            <path d="m68.029 329.215c-1.256-4.953-1.932-10.131-1.955-15.461l-.174-41.338c-.012-2.958-2.429-5.365-5.387-5.365h-29.255c-17.139 0-31.082 13.943-31.082 31.082s13.943 31.082 31.082 31.082z"/>
                        </g>
                    </svg>
                    <h1>
                        Create<br>Your Own<br>Burger<br>
                        
                    </h1>
                </div>
            </div>
            <div class="wrapper-cart">
                <form action="purchase.php" method="POST">
                    <table id="tblShoppingCart">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                echo $arr;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="lastrow">
                                    <div class="btnBlock">
                                        <a href="index.php" class="btnCart">Back to menu    </a>
                                        <button type="submit" name="btnCart" class="btnCart" <?php echo $dis; ?>>Purchase</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
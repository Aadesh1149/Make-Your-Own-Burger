<?php
    // Start session
    session_start();

    // Establish connection to the database
    $con = new mysqli("localhost", "root", "","burger_ordering");
    // if there is a problem, show error message
    if ($con -> connect_errno) {
        echo "Failed to connect to MySQL: " . $con -> connect_error;
        exit();
    }

    // Check if form is submitted
	if (isset($_POST['btnCreate'])) {
        // Variable Declaration
		$name = "My Custom Burger 1";
		$bun  = $con->real_escape_string($_POST['txtBun']);
		$meat = $con->real_escape_string($_POST['txtMeat']);
	    $tops = array_map("strip_tags", $_POST['toppings']);
        $qty  = 1;
        $price = 0;

        // Check bun then add price to total
        switch ($bun) {
            case "Brioche":
                $price += 30;
                break;
            case "Ciabatta":
                $price += 40;
                break;
            case "English":
                $price += 35;
                break;
            case "Sesame":
                $price += 35;
                break;
            default:
                break;
        }
        
        // Check meat then add price to total
        switch ($meat) {
            case "Brisket":
                $price += 250;
                break;
            case "Chuck":
                $price += 220;
                break;
            case "Round":
                $price += 200;
                break;
            case "Short":
                $price += 180;
                break;
            case "Sirloin":
                $price += 230;
                break;
            default:
                break;
        }

        // Check toppings then add price to total
        foreach($tops as &$value) {
            switch ($value) {
                case "Bell Pepper":
                    $price += 30;
                    break;
                case "Lettuce":
                    $price += 30;
                    break;
                case "Mushrooms":
                    $price += 25;
                    break;
                case "Onions":
                    $price += 25;
                    break;
                case "Pickles":
                    $price += 25;
                    break;
                case "Tomatoes":
                    $price += 20;
                    break;
                case "American Cheese":
                    $price += 35;
                    break;
                case "Brie":
                    $price += 40;
                    break;
                case "Cheddar":
                    $price += 30;
                    break;
                case "Goat Cheese":
                    $price += 50;
                    break;
                case "Monterey Jack":
                    $price += 60;
                    break;
                case "Pepper Jack":
                    $price += 60;
                    break;
                case "Provolone":
                    $price += 60;
                    break;
                default:
                    break;
            }
        }
        unset($value);
		
        $tops = implode(", ",$tops);
        // Check if shopping cart session variable is empty or has value
		if(empty($_SESSION["shopping_cart"])) {
            // Store post variables in to array
            $cartArray = array(
                $name => array(
                    'name'     => $name,
                    'bun'      => $bun,
                    'meat'     => $meat,
                    'toppings' => $tops,
                    'price'    => $price,
                    'qty'      => $qty
                )
            );
			$_SESSION["shopping_cart"] = $cartArray;
		} else{
            // Check if order has duplicates. If it has, add quantity to previous order
            $check = 0;
            $array_keys = array_keys($_SESSION["shopping_cart"]);
            foreach ($_SESSION["shopping_cart"] as $key => &$value) {
                if ($value["bun"] == $bun && $value["meat"] == $meat && $value["toppings"] == $tops) {
                    $check = 1;
                    $_SESSION["shopping_cart"][$key]["qty"] += $qty;
                }
            }
            if ($check == 0) {
                $i = 1;
                while (in_array($name, $array_keys)) {
                    $name = "My Custom Burger ".$i;
                    $i++;
                }

                $cartArray = array(
                    $name => array(
                        'name'     => $name,
                        'bun'      => $bun,
                        'meat'     => $meat,
                        'toppings' => $tops,
                        'price'    => $price,
                        'qty'      => $qty
                    )
                );
                // Merge post variables to shopping cart session
                $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
            }
		}
        // Prompt user that the item was added to the cart
        echo '<script>alert("Burger successfully added to cart!");</script>';
	}

    $arr = $cartInfo = "";
    $count_cart = 0;
    if (isset($_SESSION["shopping_cart"])) {
        print_r($_SESSION["shopping_cart"]);
        foreach ($_SESSION["shopping_cart"] as $var) {
            $count_cart += $var['qty'];
        }
        $cartInfo = "You have ".$count_cart." items in your cart.";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make your own Burger</title>
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

            <div class="content-burger">
                <div class="content-left">
                    <img src="img/burger-hero.png" alt="">
                </div>
                <div class="content-right">
                    <form action="" method="post">
                        <div class="titleBlock">
                            <div class="content">
                                <img src="img/001-bread.png" alt="">
                                <span>Bun:</span>
                            </div>
                        </div>

                        <div class="container-checkbox">
                            <hr>
                            <label class="wrapper-chk">Brioche (&#8377;30)
                                <input type="radio" name="txtBun" value="Brioche" checked="checked">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Ciabatta (&#;40)
                                <input type="radio" name="txtBun" value="Ciabatta">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">English Bun (&#8377;50)
                                <input type="radio" name="txtBun" value="English">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Sesame Bun (&#8377;35)
                                <input type="radio" name="txtBun" value="Sesame">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="titleBlock">
                            <div class="content">
                                <img src="img/036-meat.png" alt="">
                                <span>Meats:</span>
                            </div>
                        </div>
                        <div class="container-checkbox">
                            <hr>
                            <label class="wrapper-chk">Brisket (&#8377;250)
                                <input type="radio" name="txtMeat" value="Brisket" checked="checked">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Chuck Steak (&#8377;220)
                                <input type="radio" name="txtMeat" value="Chuck">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Round steak (&#8377;200)
                                <input type="radio" name="txtMeat" value="Round">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Short Rib (&#8377;180)
                                <input type="radio" name="txtMeat" value="Short">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Sirloin (&#8377;230)
                                <input type="radio" name="txtMeat" value="Sirloin">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="titleBlock">
                            <div class="content">
                                <img src="img/053-tomato.png" alt="">
                                <span>Veggies:</span>
                            </div>
                        </div>
                        <div class="container-checkbox">
                            <hr>
                            <label class="wrapper-chk">Bell Pepper (&#8377;30)
                                <input type="checkbox" name="toppings[]" value="Bell Pepper" checked="checked">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Lettuce (&#8377;30)
                                <input type="checkbox" name="toppings[]" value="Lettuce">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Mushrooms (&#8377;25)
                                <input type="checkbox" name="toppings[]" value="Mushrooms">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Onions (&#8377;25)
                                <input type="checkbox" name="toppings[]" value="Onions">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Pickles (&#8377;25)
                                <input type="checkbox" name="toppings[]" value="Pickles">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Tomatoes (&#8377;20)
                                <input type="checkbox" name="toppings[]" value="Tomatoes">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="titleBlock">
                            <div class="content">
                                <img src="img/005-cheese.png" alt="">
                                <span>Cheeses:</span>
                            </div>
                        </div>
                        <div class="container-checkbox">
                            <hr>
                            <label class="wrapper-chk">American Cheese (&#8377;35)
                                <input type="checkbox" name="toppings[]" value="American Cheese" checked="checked">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Brie (&#8377;40)
                                <input type="checkbox" name="toppings[]" value="Brie">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Cheddar (&#8377;30)
                                <input type="checkbox" name="toppings[]" value="Cheddar">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Goat Cheese (&#8377;50)
                                <input type="checkbox" name="toppings[]" value="Goat Cheese">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Monterey Jack (&#8377;60)
                                <input type="checkbox" name="toppings[]" value="Monterey Jack">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Pepper Jack (&#8377;60)
                                <input type="checkbox" name="toppings[]" value="Pepper Jack">
                                <span class="checkmark"></span>
                            </label>
                            <label class="wrapper-chk">Provolone (&#8377;60)
                                <input type="checkbox" name="toppings[]" value="Provolone">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <br>
                        <br>
                        <br>
                        <button type="submit" class="btnCreate" name="btnCreate">Place Order</button>
                        <a href="cart.php" class="btnCheckout" title="<?php echo $cartInfo; ?>">Checkout (<?php echo $count_cart; ?>)</a>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
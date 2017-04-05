<?php
/*
	* Shipping Information page.
*/
include('header.php');
?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <table style ="border-collapse: separate; border-spacing: 0 .5em;">
                <h3>Please provide your shipping information: </h3>
                <form id="shipping-form" action="checkout.php" method="post">
                    <tr>
                        <td width="30%">First Name</td>
                        <td><input type="text" name="first_name" id="first_name" value="Jane"/></td>
                    </tr>
                    <tr>
                        <td width="30%">Last Name</td>
                        <td><input type="text" name="last_name" id="last_name" value="Doe"/></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><input type="text" name="line1" id="line1" value="2211 N First Street"/></td>
                    </tr>
                    <tr>
                        <td>Address 1</td>
                        <td><input type="text" name="line2" id="line2" value=""/></td>
                    </tr>
                    <tr>
                        <td>City:</td>
                        <td><input type="text" name="city" id="city" value="San Jose"/></td>
                    </tr>
                    <tr>
                        <td>State:</td>
                        <td><input type="text" name="state" id="state" value="CA"/></td>
                    </tr>
                    <tr>
                        <td>Postal Code:</td>
                        <td><input type="text" name="postal_code" id="postal_code" value="95131"/></td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>
                            <select id="country_code" name="country_code">
                                <option selected value="US">United States</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="btn btn-primary" type="submit" value="Continue"/>
                        </td>
                    </tr>
                </form>
            </table>
        </div>
        <div class="col-md-4"></div>
    </div>

<?php
include('footer.php');
?>
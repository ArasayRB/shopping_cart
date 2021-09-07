<p><strong>Here your products cart..!</strong></p>

<?php
$page_title="Cart";
if(isset($_SESSION["message"]) && $_SESSION["message"]!='')
{
  echo "<div class='alert alert-info' id='status-msg-cart'>";
      echo "<strong>".$_SESSION["message"]."</strong> ¡Updated succefully!";
      echo '<button type="button" class="btn btn-info close-status-msg-cart"><span class ="text-light" aria-hidden="true">&times;</span></button>';
  echo "</div>";
}

if(isset($_GET["state"]))
{
  if($_GET["state"]=="noCredit")
  {
  echo "<div class='alert alert-info'>";
      echo " ¡You do not have cash for transaction!<strong> Cash available  $".number_format($_GET["cashBefore"], 2, '.', ',')."</strong>";
  echo "</div>";
  }
  else if($_GET["state"]=="errorPay")
  {
    $error="No insert";
    if(isset($_GET["error"]))
    {
      $error=$_GET["error"];
    }
  echo "<div class='alert alert-info'>";
      echo " ¡Error in the transaction!<strong>Error: ".$error."</strong>";
  echo "</div>";
  }
}

    if(count($products)>0){
      ?>
    <table class='table table-hover table-responsive table-bordered'>

    <tr>
        <th class='textAlignLeft'>Product Name- Available Stock</th>
              <th class='textAlignLeft'>Picture</th>
        <th>Price (USD)</th>
            <th style='width:15em;'>Quantity</th>
                <th></th>
            <th>Sub Totall</th>
            <th>Actions</th>
    </tr>
<?php
    for($i=0;$i<count($products);$i++)
     {
       if($products[$i]["code"]!=0)
       {
         $subtotal=$products[$i]["price"]*$products[$i]["cant"];
         echo "<tr>
         <form action='".BASE_URL."/carts/update' method='post'>
               <input type='hidden' name='action' value='updateToCart'>
               <input type='hidden' name='product-code' value='".$products[$i]["code"]."'>
               <input type='hidden' name='product-price' value='".$products[$i]["price"]."'>
               <input type='hidden' name='product-name' value='".$products[$i]["name"]."'>
               <input type='hidden' name='product-stock' value='".$products[$i]["stock"]."'>
               <input type='hidden' name='product-um' value='".$products[$i]["um"]."'>
               <input type='hidden' name='product-cant' value='".$products[$i]["cant"]."'>
               <td>
                     <div class='product-id' style='display:none;'>".$products[$i]["code"]."</div>
                     <div class='product-name'>".$products[$i]["name"]."-</div>
                             <div class='product-stock'>".$products[$i]["stock"]."/<div class='product-um'>".$products[$i]["um"]."</div></div>
                  </td>
                  <td><img src='./".$products[$i]["img"].".jpg' border='0' height='100' width='150' vspace='0' hspace='0' align='center'></td>
                  <td><div class='product-price'>&#36;" . number_format($products[$i]["price"], 2, '.', ',') . "</div></td>
                  <td>
                     <div class='input-group'>";
                       $maxQuantity=$products[$i]["stock"];
                       if($products[$i]["stock"]<$products[$i]["cant"])
                       {
                         $maxQuantity=$products[$i]["cant"];
                       }
                   echo "<input type='number' id='quantity' pattern='[0-9]' name='quantity' min='1' max='".$maxQuantity."' value='".$products[$i]["cant"]."' class='form-control'>

                     </div>
                  </td>
                  <td>
                       <button class='btn btn-info' >
                       <span class='glyphicon glyphicon-refresh'></span> Update
                       </button>
                  </td>
                 </form>
                  <td>&#36;" . number_format($subtotal, 2, '.', ',') . "</td>
                  <td>
                      <form action='".BASE_URL."/carts/delete' method='post'>
                      <input type='hidden' name='product-code' value='".$products[$i]["code"]."'>
                      <input type='hidden' name='product-price' value='".$products[$i]["price"]."'>
                      <input type='hidden' name='product-name' value='".$products[$i]["name"]."'>
                      <input type='hidden' name='product-stock' value='".$products[$i]["stock"]."'>
                      <input type='hidden' name='product-um' value='".$products[$i]["um"]."'>
                      <input type='hidden' name='product-cant' value='".$products[$i]["cant"]."'>
                      <button class='btn btn-danger' >
                      <span class='glyphicon glyphicon-remove'></span> Delete in Cart
                      </button>
                      </form>
                  </td>
                </tr>";
       }
     }
     echo "<tr>
            <td><b>Your Available Cash</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&#36;" . number_format($cash, 2, '.', ',') . "</td>
            <td>
            </td>
          </tr>
          <tr>
              <td><b>Totall</b></td>
              <td></td>
              <td></td>
              <td></td>
              <td>&#36;" . number_format($total, 2, '.', ',') . "</td>
              <td>
                 <form name='formRadio'>

                  <label>Choice your option</label>
                   <input type='radio' name='pick' value='pickUp'> Pick Up ($0 USD)
                   <input type='radio' name='pick' value='ups'> UPS ($5 USD)";
                   echo "<label>Totall plus UPS: &#36;".number_format($totalUps, 2, '.', ',')."</label>
                   <div></div>
                 <button class='btn btn-success' id='btnPay'>
                   <span class='glyphicon glyphicon-shopping-cart'></span> Pay
                 </button>

                </form>
              </td>
              </tr>";
              ?>
    </table>
  <?php
}
  else
  {
      echo "<div class='alert alert-danger'>";
      echo "<strong>No products found</strong> in cart!";
      echo "</div>";
  }
?>

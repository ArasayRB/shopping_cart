<p><strong>Welcome to our shopping cart..!</strong></p>
<?php
$page_title="Products List";
  if(isset($_SESSION["message"]) && $_SESSION["message"]!='')
  {
    echo "<div class='alert alert-info' id='status-msg-prod'>";
        echo "<strong>".$_SESSION["message"]."</strong> ¡Added to your cart succefully!";
        echo '<button type="button" class="btn btn-info close-status-msg-prod"><span class ="text-light" aria-hidden="true">&times;</span></button>';
    echo "</div>";
  }

  if(isset($_SESSION["error"]))
  {
    echo "<div class='alert alert-info'>";
        echo "¡Error! <strong>".$_SESSION["error"]."</strong>";
    echo "</div>";
  }

  if(isset($_GET["state"]))
  {
    if($_GET["state"]=="succefully")
    {
      ?>
    <div class='alert alert-info'>
        ¡Transaction succefully!
        <table class='table table-hover table-responsive table-bordered'>
                <tr>
                  <th>Initial credit (USD)</th>
                  <th>Cost transaction (USD)</th>
                  <th>Credit after pay (USD)</th>
               </tr>
               <tr>
               <?php
               echo "<td>&#36;" . number_format($_GET["cashBefore"], 2, '.' , ',') . "</td>
               <td>&#36;" . number_format($_GET["cost"], 2, '.' , ',') . "</td>
               <td>&#36;" . number_format($_GET["cashAfter"], 2, '.' , ',') . "</td>";
               ?>
               </tr>
               </table>
    </div>
    <?php
    }
  }
  $logEmail;
  if(isset($_SESSION["check"]))
  {
    $logEmail=$_SESSION["name"];
  }
?>
<input type='hidden' name='base_url' id='base_url' value="<? echo BASE_URL; ?>">
<table class='table table-hover table-responsive table-bordered'>
        <tr>
          <th>Rating</th>
          <th class='textAlignLeft'>Product Name- Available Stock</th>
          <th class='textAlignLeft'>Picture</th>
          <th>Price (USD)</th>
          <th style='width:5em;'>Quantity</th>
          <th>Actions</th>
       </tr>
<?php
for($i=0;$i<count($products);$i++)
{
  if($products[$i]["code"]!=0)
  {

    echo"<tr>
    <td>
    <div class='clasification'>";
    $checkedClasif=$clasificationStars[$products[$i]["code"]]["isCheck"];

      if($checkedClasif==5)
      {
       echo" <input id='".$products[$i]["code"]."-1' type='radio' name='".$products[$i]["code"]."' value='5' disabled checked><!---->
        <label for='".$products[$i]["code"]."-1'>&#9733</label><!---->";
      }
      else
      {
       // code...
       echo "<input id='".$products[$i]["code"]."-1' type='radio' name='".$products[$i]["code"]."' value='5'><!---->
      <label for='".$products[$i]["code"]."-1'>&#9733</label><!---->";
      }
      if($checkedClasif==4)
      {
       echo" <input id='".$products[$i]["code"]."-2' type='radio' name='".$products[$i]["code"]."' value='4' disabled checked><!---->
      <label for='".$products[$i]["code"]."-2'>&#9733</label><!---->";
      }
      else
      {
       // code...
       echo "<input id='".$products[$i]["code"]."-2' type='radio' name='".$products[$i]["code"]."' value='4'><!---->
      <label for='".$products[$i]["code"]."-2'>&#9733</label><!---->";
      }
      if($checkedClasif==3)
      {
       echo" <input id='".$products[$i]["code"]."-3' type='radio' name='".$products[$i]["code"]."' value='3' disabled checked><!---->
      <label for='".$products[$i]["code"]."-3'>&#9733</label><!---->";
      }
      else
      {
       // code...
       echo "<input id='".$products[$i]["code"]."-3' type='radio' name='".$products[$i]["code"]."' value='3'><!---->
      <label for='".$products[$i]["code"]."-3'>&#9733</label><!---->";
      }
      if($checkedClasif==2)
      {
       echo" <input id='".$products[$i]["code"]."-4' type='radio' name='".$products[$i]["code"]."' value='2' disabled checked><!---->
      <label for='".$products[$i]["code"]."-4'>&#9733</label><!---->";
      }
      else
      {
       // code...
       echo "<input id='".$products[$i]["code"]."-4' type='radio' name='".$products[$i]["code"]."' value='2'><!---->
      <label for='".$products[$i]["code"]."-4'>&#9733</label><!---->";
      }
      if($checkedClasif==1)
      {
       echo" <input id='".$products[$i]["code"]."-5' type='radio' name='".$products[$i]["code"]."' value='1' disabled checked><!---->
      <label for='".$products[$i]["code"]."-5'>&#9733</label><!---->";
      }
      else
      {
       // code...
       echo "<input id='".$products[$i]["code"]."-5' type='radio' name='".$products[$i]["code"]."' value='1'><!---->
      <label for='".$products[$i]["code"]."-5'>&#9733</label><!---->";
      }


    echo"<div class='rating'><strong>".round($clasificationStars[$products[$i]["code"]]["puntiationProduct"],2)."/5</strong></div>
    <div>";
    if($checkedClasif!=0)
    {
    echo "<button class='btn btn-primary sendCassif' disabled>
     Send
    </button>";
    }
    else
    {
      echo "
      <button class='btn btn-primary sendCassif'>
       Send
      </button>";
    }
    echo "</div>
    </div>
    </td>
    <form action='".BASE_URL."/carts/add' method='post'>
          <input type='hidden' name='action' value='addToCart'>
          <input type='hidden' name='product-code' value='".$products[$i]["code"]."'>
          <input type='hidden' name='product-price' value='".$products[$i]["price"]."'>
          <input type='hidden' name='product-name' value='".$products[$i]["name"]."'>
          <input type='hidden' name='product-stock' value='".$products[$i]["stock"]."'>
          <input type='hidden' name='product-um' value='".$products[$i]["um"]."'>
          <input type='hidden' name='product-img' value='".$products[$i]["img"]."'>
          <td>
            <div class='product-id' style='display:none;'>".$products[$i]["code"]."</div>
            <div class='product-name'>".$products[$i]["name"]."-</div>
            <div class='product-stock'>".$products[$i]["stock"]."/".$products[$i]["um"]."</div>
           </td>
           <td><img src='./".$products[$i]["img"].".jpg' border='0' height='100' width='150' vspace='0' hspace='0' align='center'></td>
           <td>&#36;" . number_format($products[$i]["price"], 2, '.' , ',') . "</td>";

  if($clasificationStars[$products[$i]["code"]]["isThereProduct"]=="true")
  {

    $sum+=$products[$i]["price"]*$products[$i]["stock"];
    echo "<td>
            <input type='text' id='quantity' name='quantity' value='".$clasificationStars[$products[$i]["code"]]["cantProducts"]."' disabled class='form-control' />
          </td>
          <td>
            <button class='btn btn-success' disabled>
              <span class='glyphicon glyphicon-shopping-cart'></span> Added!
            </button>
          </td>";
  }
  else
  {
    echo "<td>
               <input type='number' name='quantity' min='1' max='".$products[$i]["stock"]."' value='1' class='form-control' />
          </td>
          <td>
               <button class='btn btn-primary add-product-to-cart' >
               <span class='glyphicon glyphicon-shopping-cart'></span> Add to cart
               </button>
          </td>";
  }
    echo "</form>
    </tr>";
  }
}
?>
    </table>

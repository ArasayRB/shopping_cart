<?php
ob_start();
session_start();
$error = ob_get_clean();
?>
    </div>
    <!-- /container -->


<!-- bootstrap JavaScript -->
<script src="./library/js/bootstrap.min.js"></script>
<script src="./library/js/holder.js"></script>
<script>
function comprobar(checkbox)
{
  alert("You go to check a checkbox");
  otro= checkbox.parentNode.querySelector("[type=checkbox]:not(#"+ checkbox.id+")");
  if(otro.checked)
  {
    otro.checked= false;
  }
}

$(document).ready(function()
{

  $("input.star").rating();


//This method insert in db the clasification user for product
  $('.sendCassif').click(function(){
    var prueba=$("input[type=radio]");
    var productCheckeado;
    var productCode;
    var productFindCheck="false";
for (var i=0; i<prueba.length; i++)
{
if(prueba[i].checked==true)
{
  productCheckeado=prueba[i].value;
  productCode=prueba[i].name;
  productFindCheck="true";
  $.ajax({
    url:'/carrito/products/stars_value',
    type:'post',
    data:{'stairs':productCheckeado,'codeProduct':productCode},
    dataType:"json",
    success:function(data){
      if(data.state=="succefully")
     {
                  window.location.href = "/carrito/products";
     }
     else
     {
       window.location.href = "/carrito";
     }
    },
    error: function(error){
      console.log(error);
    }
  });
}
}

if(productFindCheck=="false")
{
  alert("No ha seleccionado una opcion");
}
     });

//This method close welcome message on app
  $('.close-wcm-msg').click(function(){
    $("#msg-welcome").css("display", "none");
  });

//This method close status message in products page on app
  $('.close-status-msg-prod').click(function(){
    <?php
    $_SESSION['message']='';
    ?>
    $("#status-msg-prod").css("display", "none");
  });

//This method close status message in cart page on app
  $('.close-status-msg-cart').click(function(){
    <?php
    $_SESSION['message']='';
    ?>
    $("#status-msg-cart").css("display", "none");
  });



  $("#btnPay").on("click",function(e)
{
  e.preventDefault();
  var seleccionado=document.formRadio.pick;
  var toPost=seleccionado.checked;
  var i;
  var selected;
  var mssg='Great! You payed succefully, thanks! Your Transaction Details- cost : $';
  if(seleccionado[0].checked==true){
    selected=seleccionado[0].value;
    $.ajax({
      url:"/carrito/carts/pay",
      dataType:"json",
      method:'post',
      data:{'radio':selected},
      success:function(data){
       if(data.state=="succefully")
       {
    if(data.cost!=0){
    if(selected=="ups"&&data.cost!=5){
      mssg+=data.cost+' amount before transaction : $'+data.cashBefore+' amount after transaction: $'+data.cashAfter;
      alert(mssg);

         window.location.href = "/carrito/products";
      }
    else if(selected!="ups"){
      mssg+=data.cost+' amount before transaction : $'+data.cashBefore+' amount after transaction: $'+data.cashAfter;
      alert(mssg);
      window.location.href = "/carrito/products";
     }
     }

       }
       else
       {
         alert('¡You do not have cash for transaction! Cash available  $'+data.cashBefore);
        window.location.href = "/carrito/carts";
      }

      },
      error: function(error)
      {
        console.log(error);
      }
    });
  }
  else if(seleccionado[1].checked==true){
  selected=seleccionado[1].value;
  $.ajax({
    url:"/carrito/carts/pay",
    dataType:"json",
    method:'post',
    data:{'radio':selected},
    success:function(data){
     if(data.state=="succefully")
     {
       mssg+=data.cost+' amount before transaction : $'+data.cashBefore+' amount after transaction: $'+data.cashAfter;
       alert(mssg);
       window.location.href = "/carrito/products";
     }
     else
     {
      window.location.href = "/carrito/carts";
     }

    },
    error: function(error)
    {
      console.log(error);
    }
  });
  }
  else
    {
    alert("You need choice an option before pay!");
    }
});
});
</script>
</body>
</html>

<div class='overlay'>
<!-- LOGN IN FORM by Omar Dsoky -->
<form action="<?php echo BASE_URL; ?>/login" method='post'>
<input type='hidden' name='action' value='login'>
<!--   con = Container  for items in the form-->
<div class='con'>
<!--     Start  header Content  -->
<header class='head-form'>
<!--     A welcome message or an explanation of the login form -->
<p class="text-uppercase text-light font-weigth-bold">login here using your username and password</p>
<?php
/**
 * This message is captured by User_Controller on login method when data are incorrect.
 */
if(isset($_SESSION["message"]) && $_SESSION["message"]!='')
{
  echo "<div class='".$_SESSION["type"]." alert-".$_SESSION["type"]."'>";
      echo "<strong class='text-center'>".$_SESSION["message"]."</strong>";
  echo "</div>";
}

?>
</header>
<!--     End  header Content  -->
<br>
<div class='field-set'>

<!--   user name -->
   <span class='input-item'>
     <i class='fa fa-user-circle'></i>
   </span>
  <!--   user name Input-->
    <input class='form-input' id='txt-input' name='txt-input' type='text' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$' title='Email correctly' placeholder='@UserName' required>

<br>

     <!--   Password -->

<span class='input-item'>
  <i class='fa fa-key'></i>
 </span>
<!--   Password Input-->
<input class='form-input' type='password' placeholder='Password' id='pwd'  name='password' autocomplete='off' required>

<br>
<!--        buttons -->
<!--      button LogIn -->
<button class='log-in'> Log In </button>
</div>

</div>

<!--   End Conrainer  -->
</div>

<!-- End Form -->
</form>
</div>

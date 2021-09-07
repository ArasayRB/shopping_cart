<?php
namespace carrito;

class autoloadCart {
	public static function init()
    {
        spl_autoload_register(function ($class) {

					//class directories
					$file=str_replace ('\\', '/', $class);


							 //see if the file exsists
							 if(file_exists(__DIR__.'/'.$file.'.php'))
							 {
										require_once(__DIR__.'/'.$file.'.php');
									 //only require the class once, so quit after to save effort (if you got more, then name them something else
									 return;
							 }
							 else  if(file_exists(__DIR__.'/'.$file.'_Controller.php'))
							 {
									 require_once(__DIR__.'/'.$file.'_Controller.php');
									 //only require the class once, so quit after to save effort (if you got more, then name them something else
									 return;
							 }
        });
    }

}

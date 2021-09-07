<?php
namespace config;

use Exception;

class Common
{
    public static function env($clave, $valorPorDefecto = null)
    {
        /**
        *This small cache system save values of ENV on Ram memory
        *The time live be same as script
        *With this when call several times to ENV the answare go to came since constante
        *Only fisrt time go to came since hard drive
        */
        if (defined("_ENV_CACHE")) {
            $configuraciones = _ENV_CACHE;
        } else {
            $archivo = API_DIRECTORY . "/.env";
            if (!file_exists($archivo)) {
                throw new Exception("Configuration file: ($archivo) no exist");
            }
            $configuraciones = parse_ini_file($archivo);
            define("_ENV_CACHE", $configuraciones);
        }
        if (isset($configuraciones[$clave])) {
            return $configuraciones[$clave];
        } else {
            if ($valorPorDefecto) {
                return $valorPorDefecto;
            }

            throw new Exception("On configuration file no exist the key: (" . $clave . ") ");
        }
    }
}

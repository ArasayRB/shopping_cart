<?php
namespace app;

use \Valitron\Validator as Validate;

class Validator
{
    public static function validateOrRedirect($data, $rules, $route = null)
    {
        $validate = new Validate($data);
        $validate->rules($rules);
        if (!$validate->validate()) {
            $redirect = Redirect::with([
                "form_errors" => $validate->errors(),
            ]);
            if ($route != null) {
                $redirect->to($route);
            } else {
                $redirect->back();
            }
            $redirect->do();
        }
    }
}

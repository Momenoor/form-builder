<?php namespace Momenoor\FormBuilder\Contracts;

use Illuminate\Http\Request;

interface FormStateContract {

    public function getEdit($id);
    public function postEdit(Request $request);
}

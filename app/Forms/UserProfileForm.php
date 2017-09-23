<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UserProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' =>'required|min:5'
            ])
            ->add('submit', 'submit', ['label' => 'Save']);
    }
}

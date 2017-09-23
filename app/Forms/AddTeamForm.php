<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class AddTeamForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' =>'required|min:5'
            ])
            ->add('submit', 'submit', ['label' => 'Add Team']);


    }
}

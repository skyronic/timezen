<?php

namespace App\Forms;

use Carbon\Carbon;
use DateTimeZone;
use Kris\LaravelFormBuilder\Form;

class UserProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' =>'required|min:5'
            ])
            ->timezoneSelect('timezone')
            ->timestampSelect('day_start')
            ->timestampSelect('ideal_start')
            ->timestampSelect('ideal_end')
            ->timestampSelect('day_end')
            ->add('submit', 'submit', ['label' => 'Save']);
    }

    protected function timestampSelect ($key) {
        $choices = [];
        for($i = 0; $i < 48; $i++ ) {
            $ts = Carbon::create(2000, 1, 1, 0, 0, 0);
            $ts->addMinutes($i * 30);
            $choices [$i] = $ts->format("g:i A");
        }

        return $this->add($key, 'select', [
            'choices' => $choices,
            'empty_value' => 'Select'
        ]);
    }

    protected function timezoneSelect ($key) {
        $timezones = DateTimeZone::listIdentifiers();
        $choices = [];
        foreach($timezones as $tz) {
            $choices [$tz] = $tz;
        }

        return $this->add($key, 'select', [
            'choices' => $choices,
            'empty_value' => 'Select'
        ]);
    }
}

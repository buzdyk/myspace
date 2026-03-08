<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

abstract class PeriodRequest extends FormRequest
{
    public function dayOfMonth(): Carbon
    {
        return (new Carbon())->setYear((int) $this->year);
    }

    abstract public function getNav(): array;
}

<?php

namespace App\Domains\Result\Services;

use App\Models\Result;

class ResultService
{

    public function calculateTotal($scores)
    {

        $total = array_sum($scores);

        return $total;

    }


    public function computeGrade($score)
    {

        if ($score >= 70) return "A";
        if ($score >= 60) return "B";
        if ($score >= 50) return "C";
        if ($score >= 45) return "D";
        if ($score >= 40) return "E";

        return "F";
    }

}
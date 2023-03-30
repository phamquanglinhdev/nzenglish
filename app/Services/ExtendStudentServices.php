<?php

namespace App\Services;

use App\Models\Extend;
use App\Models\Student;
use Carbon\Carbon;

class ExtendStudentServices
{

    private int $extend_id;

    /**
     * @param int $extend_id
     */
    public function __construct(int $extend_id)
    {

        $this->extend_id = $extend_id;
    }

    public function update(): bool
    {
        if ($this->extend_id != null) {
            $extend = Extend::where("id", $this->extend_id)->first();
            $student = $extend->Student()->first();
            $start = Carbon::parse($extend->start_extend);
            $month = $extend->month;
            $end = Carbon::parse($start)->addMonths($month);
            $student->start = $start;
            $student->end = $end;
            $student->first_reg = 0;
            $student->save();
            $extend->confirm = 1;
            $extend->save();

            return true;
        }
        return false;
    }

}

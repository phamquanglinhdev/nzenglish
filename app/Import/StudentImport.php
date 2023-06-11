<?php

namespace App\Import;

use App\Models\Grade;
use App\Models\Invoice;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StudentImport implements \Maatwebsite\Excel\Concerns\ToCollection
{

    /**
     * @inheritDoc
     */
    public function collection(Collection $collection)
    {
//        dd($collection[0]);
        $students = [];
        foreach ($collection as $key => $row) {
            if ($row[1] == null) {
                continue;
            }
            $invoice = new \stdClass();
            $invoice->start_extend = Carbon::create(explode("/", $row[9])[2], explode("/", $row[9])[1], explode("/", $row[9])[0])->toDateString();
            $invoice->month = 6;
            $invoice->name = "Hóa đơn của $row[1]";
            $invoice->code = $key + 1;
            $invoice->value = str_replace(".", "", $row[7]);
            $invoice->method = "cash";
            $students[] = [
                'origin' => 2,
                'name' => $row[1],
                'birthday' => '2023-06-14',
                'first' => Carbon::create(explode("/", $row[5])[2], explode("/", $row[5])[1], explode("/", $row[5])[0]),
                'avatar' => null,
                'phone' => "+84" . $row[2] ?? "0",
                'grades' => [0 => Grade::getGrade($row[6])],
                'invoice' => json_encode([0 => $invoice])
            ];
        }
        foreach ($students as $data) {
            /**
             * @var Student $student
             */

            $invoice = json_decode($data["invoice"])[0];
            $data["avatar"] = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png";
            $data['start'] = Carbon::parse(now());
            $data['end'] = Carbon::parse(now());
            $student = Student::query()->create($data);
            $student->Grades()->sync($data["grades"]);
            $invoice->pack_id = 1;
            $invoice->staff_id = backpack_user()->id;
            $invoice->student_id = $student->id;
            Invoice::query()->create((array)($invoice));
        }
    }


}

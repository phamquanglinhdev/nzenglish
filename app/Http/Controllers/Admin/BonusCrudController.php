<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BonusRequest;
use App\Models\Bonus;
use App\Models\Student;
use App\Utils\FilterRole;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

/**
 * Class BonusCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BonusCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation {
        destroy as traitDestroy;
    }

    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Bonus::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/bonus');
        CRUD::setEntityNameStrings('Bù Ngày', 'Bù ngày');
        if (backpack_user()->role == "viewer") {
            $this->crud->denyAccess(["create","edit"]);
        }
        FilterRole::filterByRole($this->crud, 'bonus');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->query->where("origin", Cookie::get("origin") ?? 1);
        CRUD::column('student_name')->label("Học sinh")->type("model_function")->function_name("studentName");
        CRUD::column('all')->label("Toàn bộ")->type("check");
        CRUD::column('days')->label("Số ngày");
        CRUD::column('reason')->label("Lý do thêm");

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BonusRequest::class);


        CRUD::field('days')->label("Số ngày")->suffix("ngày")->type("number");
        CRUD::field('reason')->label("Lý do bù");
        CRUD::field('all')->type("checkbox")->label("Thêm cho toàn bộ học sinh");
        CRUD::addField([
            'name' => 'students',
            'type' => 'select2_from_array',
            'options' => Student::get()->pluck('name', 'id')->toArray(),
            'allows_multiple' => true,
        ]);
        CRUD::field("origin")->type("hidden")->value(Cookie::get("origin") ?? 1);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function store()
    {
        $request = (object)$this->crud->getRequest()->toArray();
        if ($request->all) {
            $students = Student::all();
            foreach ($students as $student) {
                $end = $student->end;
                $rs = Carbon::parse($end)->addDays($request->days ?? 0);
                $student->end = $rs;
                $student->save();
            }
        } else {
            if (!empty($request->students)) {
//                dd($request->students);
                $students = Student::whereIn("id", $request->students)->get();
                foreach ($students as $student) {
                    $end = $student->end;
                    $rs = Carbon::parse($end)->addDays($request->days ?? 0);
                    $student->end = $rs;
                    $student->save();
                }
            }
        }
        return $this->traitStore();
    }

    protected function update($id)
    {

        $old = Bonus::find($id);
        if ($old->all) {
            $students = Student::all();
            foreach ($students as $student) {
                $student->end = Carbon::parse($student->end)->subDays($old->days ?? 0);
                $student->save();
            }
        }
        if (!empty($old->students)) {
            $oldStudents = Student::whereIn("id", $old->students)->get();
            foreach ($oldStudents as $oldStudent) {
                $oldStudent->end = Carbon::parse($oldStudent->end)->subDays($old->days ?? 0);
                $oldStudent->save();
            }
        }
        $request = (object)$this->crud->getRequest()->toArray();
        if ($request->all) {
            $students = Student::all();
            foreach ($students as $student) {
                $student->end = Carbon::parse($student->end)->addDays($request->days ?? 0);
                $student->save();
            }
        }
        if (!empty($request->students)) {
            $students = Student::whereIn("id", $request->students)->get();
            foreach ($students as $student) {
                $student->end = Carbon::parse($student->end)->addDays($request->days ?? 0);
                $student->save();
            }
        }
        return $this->traitUpdate();
    }

    protected function destroy($id)
    {
        $old = Bonus::find($id);
        if ($old->all) {
            $students = Student::all();
            foreach ($students as $student) {
                $student->end = Carbon::parse($student->end)->subDays($old->days ?? 0);
                $student->save();
            }
        }
        if (!empty($old->students)) {
            $oldStudents = Student::whereIn("id", $old->students)->get();
            foreach ($oldStudents as $oldStudent) {
                $oldStudent->end = Carbon::parse($oldStudent->end)->subDays($old->days ?? 0);
                $oldStudent->save();
            }
        }
        return $this->traitDestroy($id);
    }
}

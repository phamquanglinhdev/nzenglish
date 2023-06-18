<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Operations\FetchOperation;
use App\Http\Requests\StudentRequest;
use App\Import\StudentImport;
use App\Models\Extend;
use App\Models\Invoice;
use App\Models\Reserve;
use App\Models\Student;
use App\Services\ExtendStudentServices;
use App\Utils\FilterRole;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Prologue\Alerts\Facades\Alert;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentCrudController extends CommonCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return \App\Http\Controllers\Operations\Illuminate\Database\Eloquent\Collection|\App\Http\Controllers\Operations\Illuminate\Pagination\LengthAwarePaginator|JsonResponse
     * @throws BackpackProRequiredException
     */
    public function fetchGrades()
    {
        return $this->fetch(\App\Models\Grade::class);
    }

    public function setup()
    {
        CRUD::setModel(\App\Models\Student::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
        CRUD::setEntityNameStrings('Học sinh', 'Danh sách học sinh');
        $this->crud->disableResponsiveTable();
        $this->crud->setOperationSetting('detailsRow', true);
        $this->crud->denyAccess(["show", "delete"]);
        $this->crud->addButton("line", "old", "view", "buttons.old", "line");
        FilterRole::filterByRole($this->crud, 'student');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        parent::setupCreateOperation();
        CRUD::setValidation(StudentRequest::class);


    }

    public function upload(Request $request)
    {
        $student = $request->file("students");
        Excel::import(new StudentImport, $student);
    }

    public function import()
    {
        return view("student.import");
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

    public function showDetailsRow($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $bag = [
            'student' => Student::find($id)
        ];
        return view("components.student-detail", $bag);
    }

    public function old($id)
    {
        Student::find($id)->update([
            'old' => 1
        ]);
        return redirect()->back();
    }

    public function extend(Request $request): JsonResponse
    {
        $services = new ExtendStudentServices($request->id ?? null);
        if ($services->update()) {
            return response()->json(null, 200);
        }
        return response()->json(null, 500);
    }

    public function store()
    {
        /**
         * @var Student $student
         */
        $request = $this->crud->validateRequest();
        $data = $this->crud->getStrippedSaveRequest($request);

        $invoice = json_decode($this->crud->getRequest()->get("invoice"))[0];
        if ($data["avatar"] == null) {
            $data["avatar"] = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png";
        }
        $data['start'] = Carbon::parse(now());
        $data['end'] = Carbon::parse(now());
        $student = Student::create($data);
        $student->Grades()->sync($data["grades"]);
        $invoice->pack_id = 1;
        $invoice->staff_id = backpack_user()->id;
        $invoice->student_id = $student->id;
        Invoice::create((array)($invoice));
        Alert::success(trans('backpack::crud.insert_success'))->flash();
        return redirect("admin/student");
    }

    public function deactive($id = null)
    {
        if ($id != null) {
            $student = Student::find($id);
            if (isset($student->id)) {
                $student->reserve_day = Carbon::parse(now())->diffInDays(Carbon::parse($student->end));
                $student->reserve_at = Carbon::parse(now())->toDateString();
                $student->save();
                Alert::success("Cập nhật thành công");
                return redirect("/admin/reserve");
            }
        }
        Alert::error("Cập nhật thất bại");
        return redirect()->back();
    }
}

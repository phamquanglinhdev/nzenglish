<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StudentRequest;
use App\Models\Extend;
use App\Models\Student;
use App\Services\ExtendStudentServices;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use http\Client\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentCrudController extends CommonCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws BackpackProRequiredException
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Student::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
        CRUD::setEntityNameStrings('Học sinh', 'Danh sách học sinh');
        $this->crud->disableResponsiveTable();
        $this->crud->setOperationSetting('detailsRow', true);
        $this->crud->denyAccess(["show", "delete"]);
        $this->crud->addButton("line", "old", "view", "buttons.old", "line");
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

    public function showDetailsRow($id)
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

    public function extend(\Illuminate\Http\Request $request): JsonResponse
    {
        $services = new ExtendStudentServices($request->id ?? null);
        if ($services->update()) {
            return response()->json(null, 200);
        }
        return response()->json(null, 500);
    }
}

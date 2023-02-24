<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Library\CrudPanel\Traits\Read;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentCrudController extends CrudController
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
        $this->crud->setOperationSetting('detailsRow', true);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
//        CRUD::column('origin');
        CRUD::column('id')->label("ID")->prefix("#");
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Tên học sinh',
            'wrapper' => [
                'element' => 'span',
                'class' => function ($crud, $column, $entry) {
                    if ($entry->expired()) {
                        return 'bg-dark text-white p-1 rounded';
                    } elseif ($entry->isWarning()) {
                        return 'bg-warning text-white p-1 rounded';
                    }
                }
            ]
        ]);
        CRUD::column('phone')->label("Số điện thoại");
        CRUD::column('start')->label("Ngày bắt đầu gói")->type("date");
        CRUD::column('end_date')->type("model_function")->function_name("end")->label("Ngày kết thúc gói");
        CRUD::column('grade')->label("Lớp");
//
//        CRUD::column('birthday');
//        CRUD::column('note');
//        CRUD::column('avatar');
//        CRUD::column('created_at');
//        CRUD::column('updated_at');

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
        CRUD::setValidation(StudentRequest::class);

        CRUD::field('origin')
            ->label("Chi nhánh")
            ->type("select_from_array")
            ->options([
                1 => 'Chi nhánh TPHCM',
                2 => 'Chi nhánh Bình Dương',
                3 => 'Chi nhanh Hà Nội',
            ]);
        CRUD::field('name')->label("Tên học sinh");
        CRUD::field('birthday')->label("Ngày tháng năm sinh")->wrapper([
            'class' => 'col-md-6 mb-2'
        ]);
        CRUD::field('first')->label("Ngày bắt đầu học")->wrapper([
            'class' => 'col-md-6 mb-2'
        ]);
        CRUD::field('avatar')->type("image")->crop(true)->aspect_ratio(1);
        CRUD::field('phone')->label("Số điện thoại")->type("phone");
        CRUD::field('grade')->label("Tên lớp");
        CRUD::field('days')->type("hidden");
        CRUD::field('start')->label("Ngày bắt đầu gói")->type("date")->wrapper([
            'class' => 'col-md-6 mb-2'
        ]);
        CRUD::field('cycle')->label("Chu kỳ")->type("number")->options([
        ])->default(3)->wrapper([
            'class' => 'col-md-6 mb-2'
        ]);


        CRUD::field('note')->label("Ghi chú");

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

    public function showDetailsRow($id)
    {
        $bag = [
            'student' => Student::find($id)
        ];
        return view("components.student-detail", $bag);
    }
}

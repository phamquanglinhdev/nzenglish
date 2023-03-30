<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Operations\FetchOperation;
use App\Http\Controllers\Operations\InlineCreateOperation;
use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use App\Utils\FilterRole;
use App\Utils\WeekDays;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class GradeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GradeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Grade::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/grade');
        CRUD::setEntityNameStrings('Lớp học', 'Lớp học');
        FilterRole::filterByRole($this->crud, 'grade');
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
        $this->crud->addFilter(
            [
                'name' => 'name',
                'type' => 'text',
                'label' => 'Tên lớp'
            ], false,
            function ($value) {
                $this->crud->query->where("name", "like", "%$value%");
            });
        $this->crud->addFilter(
            [
                'name' => 'status',
                'type' => 'text',
                'label' => 'Tình trạng lớp'
            ], false,
            function ($value) {
                $this->crud->query->where("status", "like", "%$value%");
            });
        CRUD::column('name')->label("Tên lớp");
        CRUD::column('level')->label("Cấp độ");
        CRUD::column('members_col')->label("Sĩ số")->type("model_function")->function_name("members");
        CRUD::column('teacher')->label("GVCN");
        CRUD::column('status')->label("Tình trạng lớp");
        CRUD::addColumn([
            'name' => 'origin',
            'type' => (backpack_user()->role == "admin" || backpack_user()->role == "staff") ? "select_editable" : "select_from_array",
            'label' => 'Chi nhánh',
            'options' => [
                1 => 'Chi nhánh TPHCM',
                2 => 'Chi nhánh Bình Dương',
                3 => 'Chi nhanh Hà Nội',
            ]
        ]);

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
        CRUD::setValidation(GradeRequest::class);
        CRUD::addField([
            'name' => 'origin',
            'type' => "select_from_array",
            'label' => 'Chi nhánh',
            'options' => [
                1 => 'Chi nhánh TPHCM',
                2 => 'Chi nhánh Bình Dương',
                3 => 'Chi nhanh Hà Nội',
            ]
        ]);
        CRUD::field('name')->label("Tên lớp");
        CRUD::field('level')->label("Cấp độ");
        CRUD::field('status')->label("Tình trạng lớp");
        CRUD::field('times')->label("Lịch học")->type("repeatable")->fields([
            [
                'name' => 'day',
                'label' => 'Ngày',
                'type' => 'select_from_array',
                'options' => WeekDays::days(),
                'wrapper' => [
                    'class' => 'col-md-4 mb-3'
                ],
                'default' => 'monday'
            ],
            [
                'name' => 'start',
                'label' => 'Bắt đầu',
                'type' => 'time',
                'wrapper' => [
                    'class' => 'col-md-4 mb-3'
                ],

            ],
            [
                'name' => 'end',
                'label' => 'Kết thúc',
                'type' => 'time',
                'wrapper' => [
                    'class' => 'col-md-4 mb-3'
                ],

            ]
        ]);
        CRUD::addField([
            'name' => 'students',
            'type' => 'relationship',
            'entity' => 'Students',
            'model' => 'App\Models\Student',
            'attribute' => 'name',
            'label' => 'Học sinh',
        ]);
        CRUD::field("teacher")->label("Giáo viên chủ nhiệm");
        CRUD::field("note")->label("Ghi chú");
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
        $grade = Grade::find($id);
        return view("grade.detail",['grade'=>$grade]);
    }
}

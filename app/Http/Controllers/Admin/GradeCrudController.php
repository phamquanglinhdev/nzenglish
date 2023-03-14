<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GradeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::column('name')->label("Tên lớp");
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
        CRUD::field('status')->label("Tình trạng lớp");

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
}

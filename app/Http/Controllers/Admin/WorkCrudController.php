<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WorkRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class WorkCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WorkCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Work::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/work');
        CRUD::setEntityNameStrings('Nhật ký làm việc', 'Nhật ký làm việc');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('date')->label("Ngày");
        CRUD::column('shift')->label("Ca");
        CRUD::column('note')->label("Ghi chú");
        CRUD::addColumn([
            'name' => 'staff_id',
            'label' => 'Nhân viên'
        ]);
        $this->crud->denyAccess(["delete"]);


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
        CRUD::setValidation(WorkRequest::class);

        CRUD::field('date')->label("Ngày")->wrapper([
            'class' => 'col-md-6 mb-3'
        ]);
        CRUD::field('shift')->label("Ca")->wrapper([
            'class' => 'col-md-6 mb-3'
        ]);
        CRUD::field('note')->label("Ghi chú");
        CRUD::addField([
            'name' => 'staff_id',
            'label' => 'Nhân viên',
            'type' => 'hidden',
            'value' => backpack_user()->id,
        ]);
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

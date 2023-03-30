<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OldRequest;
use App\Models\Old;
use App\Models\Scopes\StudentScope;
use App\Models\Student;
use App\Utils\FilterRole;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OldCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OldCrudController extends CommonCrudController
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
        parent::setup();
        CRUD::setModel(\App\Models\Old::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/old');
        CRUD::setEntityNameStrings('Học sinh cũ', 'Học sinh cũ');
        $this->crud->denyAccess(["create", "update"]);
        $this->crud->allowAccess(["delete"]);
        $this->crud->removeAllButtons();
        $this->crud->addButton("line", "repurchase", "view", "buttons.repurchase");
        FilterRole::filterByRole($this->crud, 'old');
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
        CRUD::setValidation(OldRequest::class);

        CRUD::field('origin');
        CRUD::field('name');
        CRUD::field('phone');
        CRUD::field('first');
        CRUD::field('start');
        CRUD::field('grade');
        CRUD::field('birthday');
        CRUD::field('note');
        CRUD::field('avatar');
        CRUD::field('days');

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
            'student' => Old::withoutGlobalScope(StudentScope::class)->find($id)
        ];
        return view("components.student-detail", $bag);
    }

    public function restore($id)
    {
        Old::find($id)->update([
            'old' => 0
        ]);
        return redirect()->back();
    }
}

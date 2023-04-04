<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Operations\ExtendOperation;
use App\Http\Requests\ExtendRequest;
use App\Models\Extend;
use App\Services\ExtendStudentServices;
use App\Utils\FilterRole;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\Facades\Alert;

/**
 * Class ExtendCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ExtendCrudController extends InvoiceCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ExtendOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Extend::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/extend');
        CRUD::setEntityNameStrings('Hóa đơn gia hạn', 'Hóa đơn gia hạn');
        $this->crud->denyAccess(["create", "update"]);
        FilterRole::filterByRole($this->crud, 'extend');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        Widget::add([
            'type' => 'view',
            'view' => 'components.extend_all'
        ]);
//        CRUD::addButton('line', 'extend', 'view', 'crud::buttons.extend');
        parent::setupListOperation();
        $this->crud->removeColumn("pack");
        $this->crud->removeColumn("confirm");
        CRUD::addColumn([
            'name' => 'start_extend',
            'label' => 'Ngày bắt đầu',
            'type' => 'date'
        ]);
        CRUD::addColumn([
            'name' => 'month',
            'label' => 'Chu kỳ gia hạn',
            'suffix' => ' tháng'
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
        CRUD::setValidation(ExtendRequest::class);

        CRUD::field('code');
        CRUD::field('confirm');
        CRUD::field('image');
        CRUD::field('method');
        CRUD::field('name');
        CRUD::field('note');
        CRUD::field('pack_id');
        CRUD::field('staff_id');
        CRUD::field('student_id');
        CRUD::field('value');

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

    public function extendAll(): RedirectResponse
    {
        $extends = Extend::where("confirm", 0)->get();
        foreach ($extends as $extend) {
            $services = new ExtendStudentServices($extend->id ?? null);
            $services->update();
        }
        Alert::success("Thành công");
        return redirect()->back();
    }
}

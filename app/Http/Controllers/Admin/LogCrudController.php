<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LogRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class LogCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LogCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Log::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/logs');
        CRUD::setEntityNameStrings('Nhật ký lớp học', 'Nhật ký lớp học');
        $this->crud->addFilter([
            'name' => 'grade',
            'label' => 'Lớp',
            'type' => 'text'
        ], false,
            function ($value) {
                $this->crud->query->whereHas("grade", function (Builder $builder) use ($value) {
                    $builder->where("name", "like", "%$value%");
                });
            }
        );
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('grade_id')->label("Lớp")->type("select");
        CRUD::column("date")->type("date")->label("Ngày");
        CRUD::column('attendances')->label("Sĩ số");
//        CRUD::column('note');
        CRUD::column('status')->label("Tình trạng buổi học")->type("select_from_array")->options(['Tốt', 'Không tốt']);
        CRUD::addColumn(
            [
                'name' => 'author_id',
                'label' => 'Cập nhật bởi'
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
        CRUD::setValidation(LogRequest::class);
        CRUD::field('grade_id')->label("Lớp")->type("select2")->wrapper([
            'class' => 'col-md-6 mb-3'
        ]);
        CRUD::field("date")->type("date")->label("Ngày")->wrapper([
            'class' => 'col-md-6 mb-3'
        ]);;
        CRUD::field('attendances')->label("Sĩ số")->suffix("Học sinh")->wrapper([
            'class' => 'col-md-6 mb-3'
        ]);
        CRUD::field('status')->label("Tình trạng buổi học")->type("select_from_array")->options(['Tốt', 'Không tốt'])->wrapper([
            'class' => 'col-md-6 mb-3'
        ]);
        CRUD::field('note')->label("Ghi chú");
        CRUD::field("author_id")->value(backpack_user()->id)->type("hidden");
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

    protected function autoSetupShowOperation()
    {
        $this->setupListOperation();
        CRUD::addColumn([
            'name' => 'note',
            'type' => 'textarea',
            'label' => 'Ghi chú',
        ]);
    }
}

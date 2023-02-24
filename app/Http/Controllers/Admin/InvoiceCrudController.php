<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvoiceRequest;
use App\Models\Student;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class InvoiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvoiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Invoice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invoice');
        CRUD::setEntityNameStrings('Hóa đơn', 'Hóa đơn');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'student',
            'label' => 'Học sinh'
        ]);
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Tên hóa đơn'
        ]);
        CRUD::addColumn([
            'name' => 'value',
            'label' => 'Số tiền',
            'type' => 'number',
            'suffix' => ' đ',
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
        CRUD::setValidation(InvoiceRequest::class);
        if (isset($_REQUEST["repurchase"])) {
            try {
                $student = Student::find($_REQUEST["repurchase"]);
                CRUD::addField([
                    'name' => 'student_id',
                    'label' => 'Học sinh',
                    'value' => $student->id,
                    'wrapper' => [
                        'class' => 'col-md-6 mb-2'
                    ]
                ]);
                CRUD::field('cycle')->label("Chu kỳ")->type("number")->suffix("Tháng")->value($student->cycle)->wrapper([
                    'class' => 'col-md-6 mb-2'
                ]);
                CRUD::addField([
                    'name' => 'repurchase',
                    'value' => $student->id,
                    'type' => 'hidden'
                ]);
            } catch (\Exception $exception) {
                CRUD::addField([
                    'name' => 'student_id',
                    'label' => 'Học sinh',
                    'value' => ''
                ]);
            }

        } else {
            CRUD::addField([
                'name' => 'student_id',
                'label' => 'Học sinh',
                'value' => ''
            ]);
        }
//
        if (isset($_REQUEST["repurchase"])) {
            try {
                $student = Student::find($_REQUEST["repurchase"]);
                CRUD::addField([
                    'name' => 'name',
                    'label' => 'Tên hóa đơn',
                    'value' => "Gia hạn lớp $student->grade của $student->name"
                ]);
            } catch (\Exception $exception) {
                CRUD::addField([
                    'name' => 'name',
                    'label' => 'Tên hóa đơn',
                ]);
            }
        }
        CRUD::addField([
            'name' => 'value',
            'label' => 'Số tiền',
            'type' => 'number',
            'suffix' => ' đ',
            'wrapper' => [
                'class' => 'col-md-6 mb-2'
            ]
        ]);
        CRUD::addField([
            'name' => 'method',
            'label' => 'Hình thức thanh toán',
            'type' => 'select_from_array',
            'options' => [
                'cash' => 'Tiền mặt',
                'bank' => 'Chuyển khoản'
            ],
            'wrapper' => [
                'class' => 'col-md-6 mb-2'
            ]
        ]);
        CRUD::addField([
            'name' => 'image',
            'label' => 'Hình ảnh',
            'type' => 'image',
        ]);
        CRUD::addField([
            'name' => 'note',
            'label' => 'Ghi chú',
            'type' => 'textarea',
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

    public function store(Request $request)
    {
        $month = (int)$request->cycle ?? 3;
        $student_id = $request->student_id ?? null;
        $repurchase = $request->repurchase ?? null;
        if ($repurchase != null) {
            $student = Student::find($repurchase);
            if ($student->expired()) {
                $start = Carbon::create(now());
            } else {
                $start = Carbon::create($student->end());
            }
            $student->update([
                'days' => Carbon::parse($student->start)->diffInDays(Carbon::create($student->end())->addMonths($request->cycle)),
                'start' => $start,
            ]);
        }


        // do something before validation, before save, before everything
//        $response = $this->traitStore();
        // do something after save
//        return $response;
    }
}

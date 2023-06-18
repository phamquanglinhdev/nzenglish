<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Operations\AcceptOperation;
use App\Http\Controllers\Operations\ConfirmOperation;
use App\Http\Requests\InvoiceRequest;
use App\Models\Common;
use App\Models\Invoice;
use App\Models\Pack;
use App\Utils\AutoString;
use App\Utils\FilterRole;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

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
    use ConfirmOperation;

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
        $this->crud->denyAccess(["update", "delete"]);
        FilterRole::filterByRole($this->crud, 'invoice');
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
            'name' => 'pack',
            'label' => 'Loại hóa đơn'
        ]);
        CRUD::addColumn([
            'name' => 'value',
            'label' => 'Số tiền',
            'type' => 'number',
            'suffix' => ' đ',
        ]);
        if (backpack_user()->role == "admin" || backpack_user()->role == "staff") {
            CRUD::addColumn([
                'name' => 'confirm',
                'label' => 'Duyệt',
                'type' => 'select_editable',
                'options' => [
                    0 => 'Đang chờ',
                    1 => 'Đã duyệt',
                    2 => 'Đã hủy'
                ]
            ]);
        } else {
            CRUD::addColumn([
                'name' => 'confirm',
                'label' => 'Trạng thái',
                'type' => 'select_from_array',
                'options' => [
                    0 => 'Đang chờ',
                    1 => 'Đã duyệt',
                    2 => 'Đã hủy'
                ]
            ]);
        }
        CRUD::addColumn([
            'name' => 'created_at',
            'type' => 'date',
            'label' => 'Ngày tạo'
        ]);
        CRUD::addColumn([
            'name' => 'staff_id',
            'label' => 'Nhân viên tạo'

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
                $student = Common::find($_REQUEST["repurchase"]);
                CRUD::addField([
                    'name' => 'student_id',
                    'type' => 'hidden',
                    'label' => 'Học sinh',
                    'value' => $student->id,
                ]);
                CRUD::addField([
                    'name' => 'student_at',
                    'type' => 'text',
                    'label' => 'Học sinh',
                    'value' => $student->name,
                    'wrapper' => [
                        'class' => 'col-md-6 mb-2'
                    ],
                    'attributes' => [
                        'disabled' => true,
                    ]
                ]);
                CRUD::field('month')->label("Chu kỳ")->type("number")->suffix("Tháng")->value($student->cycle)->wrapper([
                    'class' => 'col-md-6 mb-2'
                ]);
                CRUD::addField([
                    'name' => "pack_id",
                    'type' => 'hidden',
                    'value' => Pack::where("name", "Gia hạn học phí")->first()->id,
                ]);
                CRUD::field("start_extend")->label("Ngày bắt đầu")->type("date");
                CRUD::addField([
                    'name' => 'repurchase',
                    'value' => $student->id,
                    'type' => 'hidden'
                ]);
            } catch (\Exception $exception) {
                CRUD::addField([
                    'name' => 'student_id',
                    'label' => 'Học sinh',
                    'value' => '',
                    'type' => 'select2',
                    'option' => function ($query) {
                        $origin = Cookie::get("origin") ?? 1;
                        return $query->where("origin", $origin);
                    }
                ]);
            }

        } else {
            CRUD::addField([
                'name' => 'student_id',
                'label' => 'Học sinh',
                'value' => '',
                'type' => 'select2',
                'option' => function ($query) {
                    $origin = Cookie::get("origin") ?? 1;
                    $query->where("origin", $origin);
                }

            ]);
        }
//
        if (isset($_REQUEST["repurchase"])) {
            try {
                $student = Common::find($_REQUEST["repurchase"]);
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
        } else {
            CRUD::addField([
                'name' => "pack_id",
                'label' => 'Loại hóa đơn',
                'type' => 'select2',
                'attribute' => 'name',
                'attributes' => [
                    'mode' => 'event',
                    'db' => 'packs',
                ]
            ]);
            CRUD::addField([
                'name' => 'name',
                'label' => 'Tên hóa đơn',
            ]);
        }
        CRUD::addField([
            'name' => 'value',
            'label' => 'Số tiền',
            'type' => 'number',
            'suffix' => ' đ',
            'wrapper' => [
                'class' => 'col-md-6 mb-2',

            ],
            'attributes' => [
                'mode' => 'listener',
                'from' => 'packs'
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
            'name' => 'code',
            'label' => 'Mã hóa đơn',
            'value' => AutoString::invoiceCode(),
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
        CRUD::addField([
            'name' => 'staff_id',
            'value' => backpack_user()->id,
            'type' => 'hidden',
        ]);
        CRUD::addField([
            'name' => 'created_at',
            'type' => 'date',
            'label' => 'Ngày tạo',
            "value" => Carbon::now()->toDateString(),
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

//    public function store(Request $request)
//    {
//        $month = (int)$request->cycle ?? 3;
//        $repurchase = $request->repurchase ?? null;
//        if ($repurchase != null) {
//            $student = Common::find($repurchase);
//            $start = Carbon::create(now());
//            $days = Carbon::parse(now())->diffInDays(Carbon::create(now())->addMonths($month));
//            if (!$student->expired()) {
//                $days += $student->remaining();
//            }
//            DB::table("students")->where("id", $repurchase)->update([
//                'end' => Carbon::parse($start)->addDays($days + 1),
//                'start' => $start,
//                'old' => 0,
//            ]);
//        }
//
//
//        // do something before validation, before save, before everything
//        $response = $this->traitStore();
//        // do something after save
//        return $response;
//    }
}

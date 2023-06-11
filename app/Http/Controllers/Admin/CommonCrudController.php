<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StudentRequest;
use App\Models\Branch;
use App\Models\Invoice;
use App\Models\Student;
use App\Utils\FilterRole;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CommonCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Common::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
        CRUD::setEntityNameStrings('Học sinh', 'Danh sách học sinh');
        $this->crud->disableResponsiveTable();
        $this->crud->setOperationSetting('detailsRow', true);
        $this->crud->denyAccess(["show", "delete"]);
        $this->crud->addButton("line", "old", "view", "buttons.old", "line");
        FilterRole::filterByRole($this->crud, 'bonus');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'name',
            'label' => 'Tên học sinh'
        ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
            });
        // dropdown filter
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'grade',
            'label' => 'Lớp'
        ],
            false,
            function ($value) { // if the filter is active
                $this->crud->query->whereHas("grades", function (Builder $builder) use ($value) {
                    $builder->where("name", "like", "%$value%");
                });
            });
        $this->crud->addFilter([
            'name' => 'end',
            'type' => 'dropdown',
            'label' => 'Gói học phí'
        ], [
            1 => 'Còn hạn',
            2 => 'Sắp hết hạn ( dưới 7 ngày)',
            3 => 'Đã hết hạn',
        ], function ($value) { // if the filter is active
            switch ($value) {
                case 1:
                    $this->crud->query->where('end', ">=", Carbon::parse(now())->addDays(7));
                    break;
                case 2:
                    $this->crud->query->where('end', "<", Carbon::parse(now())->addDays(7))
                        ->where("end", ">=", Carbon::parse(now()));
                    break;
                case 3:
                    $this->crud->query->where("end", '<', Carbon::parse(now()));
                    break;

            }
        });
//        CRUD::column('origin');
        CRUD::column('id')->label("ID")->prefix("#");
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Tên học sinh',
            'wrapper' => [
                'element' => 'div',
                'class' => function ($crud, $column, $entry) {
                    if ($entry->expired()) {
                        return 'text-gray font-weight-bold';
                    } elseif ($entry->isWarning()) {
                        return 'text-warning font-weight-bold';
                    }
                    return 'text-success font-weight-bold';
                }
            ],
        ]);
        CRUD::column('phone')->label("Số điện thoại");
        CRUD::column('start')->label("Ngày bắt đầu gói")->type("date");
        CRUD::column('end')->type("date")->label("Ngày kết thúc gói");
        CRUD::column('grades')->label("Lớp");
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
        Widget::add()->type('style')
            ->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css');
        Widget::add()->type('script')
            ->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/js/intlTelInput-jquery.min.js');
        CRUD::field('origin')
            ->label("Chi nhánh")
            ->type("select_from_array")
            ->default( Cookie::get("origin") ?? 1)
            ->options(Branch::options());
        CRUD::field('name')->label("Tên học sinh");
        CRUD::field('birthday')->label("Ngày tháng năm sinh")->wrapper([
            'class' => 'col-md-6 mb-2'
        ]);
        CRUD::field('first')->label("Ngày bắt đầu học")->wrapper([
            'class' => 'col-md-6 mb-2'
        ]);
        CRUD::field('avatar')->type("image")->crop(true)->aspect_ratio(1);
        CRUD::field('phone')->label("Số điện thoại")->type("phone");
        CRUD::addField([
            'name' => 'grades',
            'label' => 'Lớp',
            'type' => 'relationship',
            'model' => 'App\Models\Grade',
            'entity' => 'Grades',
            'attribute' => 'name',
            'inline_create' => [
                'entity' => 'grade',
                'add_button_label' => 'Thêm kỹ lớp',
            ]
        ]);
        CRUD::field('note')->label("Ghi chú");
        if ($this->crud->getOperation() != "update") {
            CRUD::addField([
                'name' => 'invoice',
                'label' => 'Thu học phí',
                'type' => 'repeatable',
                'init_row' => 1,
                'max_rows' => 1,
                'min_rows' => 1,
                'fields' => [
                    [
                        'name' => 'start_extend',
                        'label' => 'Ngày bắt đầu gói',
                        'type' => 'date',
                        'wrapper' => [
                            'class' => 'col-md-6 mb-3'
                        ],
                        'attributes' => [
                            'required' => true
                        ]

                    ],
                    [
                        'name' => 'month',
                        'label' => 'Chu kỳ',
                        'type' => 'number',
                        'suffix' => 'tháng',
                        'wrapper' => [
                            'class' => 'col-md-6 mb-3'
                        ],
                        'attributes' => [
                            'required' => true
                        ]
                    ],
                    [
                        'name' => 'name',
                        'label' => 'Tên hóa đơn',
                        'wrapper' => [
                            'class' => 'col-md-6 mb-3'
                        ],
                        'value' => 'Hóa đơn mới',
                        'attributes' => [
                            'required' => true
                        ]
                    ],
                    [
                        'name' => 'code',
                        'label' => 'Mã hóa đơn',
                        'wrapper' => [
                            'class' => 'col-md-6 mb-3'
                        ],
                        'default' => Invoice::query()->withoutGlobalScopes()->orderBy("id","DESC")->max("code")+1,
                        'attributes' => [
                            'required' => true
                        ]
                    ],
                    [
                        'name' => 'value',
                        'label' => 'Số tiền',
                        'wrapper' => [
                            'class' => 'col-md-6 mb-3'
                        ],
                        'suffix' => "đ",
                        'value' => '0',
                        'attributes' => [
                            'required' => true
                        ]
                    ],
                    [
                        'name' => 'method',
                        'label' => 'Hình thức',
                        'wrapper' => [
                            'class' => 'col-md-6 mb-3'
                        ],
                        'type' => 'select_from_array',
                        'options' => [
                            'cash' => 'Tiền mặt',
                            'bank' => 'Chuyển khoản',
                        ],
                        'attributes' => [
                            'required' => true
                        ]
                    ],
                    [
                        'name' => 'image',
                        'label' => 'Hình ảnh',
                        'type' => 'image'
                    ],
                    [
                        'name' => 'note',
                        'label' => 'Ghi chú',
                        'type' => 'textarea'
                    ],
                ]
            ]);
        }


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

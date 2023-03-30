<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ReserveRequest;
use App\Models\Reserve;
use App\Models\Student;
use App\Utils\FilterRole;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

/**
 * Class ReserveCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ReserveCrudController extends CommonCrudController
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
        CRUD::setModel(\App\Models\Reserve::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/reserve');
        CRUD::setEntityNameStrings('Học sinh bảo lưu', 'Danh sách học sinh bảo lưu');
        $this->crud->denyAccess(["create", "show", "delete", "update"]);
        $this->crud->setOperationSetting("detailsRow", true);
        FilterRole::filterByRole($this->crud, 'reserve');
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
        $this->crud->removeColumns(["start", "end", "grades"]);
        CRUD::column("reserve_at")->label("Ngày bảo lưu")->type("date");
        CRUD::column("reserve_day")->label("Số ngày còn lại")->suffix(" ngày");

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
        CRUD::setValidation(ReserveRequest::class);

        parent::setupCreateOperation();

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
            'student' => Reserve::find($id)
        ];
        return view("components.student-detail", $bag);
    }

    public function reactive(Request $request)
    {
        $id = $request->id ?? null;
        $restart = $request->restart ?? null;
        if ($id && $restart) {
            $reserve = Reserve::find($id);
            if (isset($reserve->id)) {
                $reserve->start = Carbon::parse($restart)->toDateString();
                $reserve->end = Carbon::parse($restart)->addDays($reserve->reserve_day + 1)->toDateString();
                $reserve->reserve_day = 0;
                $reserve->reserve_at = null;
                $reserve->save();
                Alert::success("Cập nhật thành công");
                return redirect("/admin/student");
            }
        }
        Alert::error("Cập nhật thất bại");
        return redirect()->back();
    }
}

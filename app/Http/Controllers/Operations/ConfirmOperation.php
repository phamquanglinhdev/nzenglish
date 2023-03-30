<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Admin\Operations\Response;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait ConfirmOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupConfirmRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/confirm', [
            'as'        => $routeName.'.confirm',
            'uses'      => $controller.'@confirm',
            'operation' => 'confirm',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupConfirmDefaults()
    {
        CRUD::allowAccess((array)'confirm');

        CRUD::operation('confirm', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'confirm', 'view', 'crud::buttons.confirm');
            // CRUD::addButton('line', 'confirm', 'view', 'crud::buttons.confirm');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function confirm()
    {
        CRUD::hasAccessOrFail('confirm');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Confirm '.$this->crud->entity_name;

        // load the view
        return view('crud::operations.confirm', $this->data);
    }
}

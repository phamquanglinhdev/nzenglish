<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait ExtendOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupExtendRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/extend', [
            'as'        => $routeName.'.extend',
            'uses'      => $controller.'@extend',
            'operation' => 'extend',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupExtendDefaults()
    {
        CRUD::allowAccess((array)'extend');

        CRUD::operation('extend', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'extend', 'view', 'crud::buttons.extend');
             CRUD::addButton('line', 'extend', 'view', 'crud::buttons.extend',"beginning");
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function extend()
    {
        CRUD::hasAccessOrFail('extend');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Extend '.$this->crud->entity_name;

        // load the view
        return view('crud::operations.extend', $this->data);
    }
}

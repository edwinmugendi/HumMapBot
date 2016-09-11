<?php

namespace Lava\Docs;

/**
 * S# DocController() function
 * Doc controller
 * @author Edwin Mugendi
 */
class DocController extends DocsBaseController {

    //Controller
    public $controller = 'doc';
    public $modules = array('accounts', 'payments', 'products', 'organizations');

    /**
     * S# getDocs() function
     * @author Edwin Mugendi
     * Load the following pages
     * 1. Register page
     * 2. Login page
     * 3. Reset password page
     * 4. Forgot password page
     */
    public function getDocs() {

        $this->crudId = 40; //So that not to call validationEngine
        //Prepare view data
        $this->view_data = $this->prepareViewData('docs');

        //Set module view to view data
        $this->view_data['modulesView'] = $this->buildModuleDocs();

        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Set layout's side bar partial
        $this->layout->sideBarPartial = '';

        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        //Set container view
        $this->layout->containerView = $this->getContainerViewPartialView();

        //Render page
        return $this->layout;
    }

//E# getDocs() function

    private function buildModuleDocs() {
        $docs = '';
        foreach ($this->modules as $singleModule) {
            $view_data['docs'] = \Lang::get($this->package . '::' . $singleModule);

            //Set module view
            $docs .= \View::make($this->package . '::' . $this->controller . '.docSingleModuleView')
                            ->with('view_data', $view_data)->render();

            foreach ($view_data['docs']['api'] as $singleApi) {
                $view_data['api'] = $singleApi;

                $docs .= \View::make($this->package . '::' . $this->controller . '.docSingleApiView')
                                ->with('view_data', $view_data)->render();

                $this->buildTable($view_data, $docs, $singleApi['parameters'], 'parameters');

                $this->buildTable($view_data, $docs, $singleApi['returns'], 'returns');
            }
        }
        return $docs;
    }

    public function buildTable(&$view_data, &$docs, $parameters, $type, $heading = null) {

        $tableBody = '';
        foreach ($parameters as $singleParameter) {

            //heading
            $view_data['header'] = $heading ? $heading : \Str::title($type);

            $view_data['heading'][0] = $type == 'parameters' ? 'Field' : 'Action';
            $view_data['heading'][1] = $type == 'parameters' ? 'Data type' : 'Http status code';
            $view_data['heading'][2] = $type == 'parameters' ? 'Note' : 'Note';
            $view_data['heading'][3] = $type == 'parameters' ? 'Required / Optional' : 'Example';

            if ($type == 'parameters' && is_array($singleParameter['dataType'])) {
                $this->buildTable($view_data, $docs, $singleParameter['dataType'], 'parameters', $singleParameter['field']);

                $singleParameter['dataType'] = 'array';
            }

            $view_data['tableData'][0] = $type == 'parameters' ? $singleParameter['field'] : $singleParameter['action'];
            $view_data['tableData'][1] = $type == 'parameters' ? $singleParameter['dataType'] : $singleParameter['httpCode'];
            $view_data['tableData'][2] = $type == 'parameters' ? $singleParameter['note'] : $singleParameter['note'];
            $view_data['tableData'][3] = $type == 'parameters' ? $singleParameter['required'] : $singleParameter['example'];


            $tableBody .= \View::make($this->package . '::' . $this->controller . '.docTableRowView')
                            ->with('view_data', $view_data)->render();
        }
        $view_data['tableBody'] = $tableBody;

        $docs .=\View::make($this->package . '::' . $this->controller . '.docTableView')
                        ->with('view_data', $view_data)->render();
    }

}

//E# DocController() function
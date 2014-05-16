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
    public $modules = array('accounts','payments','products');

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
        //Prepare view data
        $viewData = $this->prepareViewData('docs');

        $this->layout->title = \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($viewData['page']);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($viewData['page']);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView($viewData);

        //Set layout's side bar partial
        $this->layout->sideBarPartial = $this->getSideBarPartialView($viewData);

        //Set module view to view data
        $viewData['modulesView'] = $this->buildModuleDocs();

        //Set layout's content view
        $this->layout->contentView = \View::make($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['view'])
                ->with('viewData', $viewData);

        //Render page
        return $this->layout;
    }

//E# getDocs() function

    private function buildModuleDocs() {
        $docs = '';
        foreach ($this->modules as $singleModule) {
            $viewData['docs'] = \Lang::get($this->package . '::' . $singleModule);

            //Set module view
            $docs .= \View::make($this->package . '::' . $this->controller . '.docSingleModuleView')
                            ->with('viewData', $viewData)->render();

            foreach ($viewData['docs']['api'] as $singleApi) {
                $viewData['api'] = $singleApi;

                $docs .= \View::make($this->package . '::' . $this->controller . '.docSingleApiView')
                                ->with('viewData', $viewData)->render();

                $this->buildTable($viewData, $docs, $singleApi['parameters'], 'parameters');

                $this->buildTable($viewData, $docs, $singleApi['returns'], 'returns');
            }
        }
        return $docs;
    }

    public function buildTable(&$viewData, &$docs, $parameters, $type,$heading = null) {
           
        $tableBody = '';
        foreach ($parameters as $singleParameter) {
            //heading
            $viewData['header'] = $heading? $heading:\Str::title($type);
            
            $viewData['heading'][0] = $type == 'parameters' ? 'Field' : 'Action';
            $viewData['heading'][1] = $type == 'parameters' ? 'Data type' : 'Http status code';
            $viewData['heading'][2] = $type == 'parameters' ? 'Note' : 'Note';
            $viewData['heading'][3] = $type == 'parameters' ? 'Required / Optional' : 'Example';
            
            if($type == 'parameters' && is_array($singleParameter['dataType'])){
                $this->buildTable($viewData, $docs, $singleParameter['dataType'], 'parameters',$singleParameter['field']);
            
                $singleParameter['dataType'] = 'array';
            }
            $viewData['tableData'][0] = $type == 'parameters' ? $singleParameter['field'] : $singleParameter['action'];
            $viewData['tableData'][1] = $type == 'parameters' ? $singleParameter['dataType'] : $singleParameter['httpCode'];
            $viewData['tableData'][2] = $type == 'parameters' ? $singleParameter['note'] : $singleParameter['note'];
            $viewData['tableData'][3] = $type == 'parameters' ? $singleParameter['required'] : $singleParameter['example'];


            $tableBody .= \View::make($this->package . '::' . $this->controller . '.docTableRowView')
                            ->with('viewData', $viewData)->render();
        }
        $viewData['tableBody'] = $tableBody;

        $docs .=\View::make($this->package . '::' . $this->controller . '.docTableView')
                        ->with('viewData', $viewData)->render();
    }

}

//E# DocController() function
<?php

class GeneratorController extends BaseController {

    public $controller = 'generator';
    private $workbenchFolder = 'lava';
    private $controllers = array(
        //Accounts
        'Lava\Accounts\UserController',
        'Lava\Accounts\VehicleController',
        'Lava\Accounts\LeadController',
        //Merchants
        'Lava\Merchants\MerchantController',
        'Lava\Merchants\LocationController',
        //Products
        'Lava\Products\ProductController',
        'Lava\Products\PromotionController',
        'Lava\Products\ReferralController',
        //Payments
        'Lava\Payments\TransactionController',
        'Lava\Payments\CardController',
    );

    public function generateViews() {
        foreach ($this->controllers as $controller) {

            $controller = new $controller();

            echo $controller->controller . "\n";
            //Cache model namespace
            $model = \Util::buildNamespace($controller->package, $controller->controller, 2);

            //Create a model
            $this_model = new $model();

            //Create single file name
            $single_file_name = $controller->controller . 'ListSingleView.php';

            //Single view path
            $view_path = base_path() . '/workbench/' . $this->workbenchFolder . '/' . $controller->package . '/src/views/' . $controller->controller;

            //Full single path
            $full_single_path = $view_path . '/' . $single_file_name;

            //Template single path
            $template_single_path = \File::exists($view_path . '/' . 'singleView.php') ? $controller->package . '::' . $controller->controller . '.singleView' : 'views.singleView';

            //Get single view
            $single_view = \View::make($template_single_path)
                    ->with('fields', $this_model->viewFields)
                    ->with('imageable', $controller->imageable)
                    ->render();

            if (\File::exists($full_single_path)) {//Single file exists
                \File::put($full_single_path, $single_view);

                //Create list file name
                $list_file_name = $controller->controller . 'ListView.php';

                //Full list path
                $full_list_path = $view_path . '/' . $list_file_name;

                //Template list path
                $template_list_path = \File::exists($view_path . '/' . 'listView.php') ? $controller->package . '::' . $controller->controller . '.listView' : 'views.listView';

                //Get list view
                $list_view = \View::make($template_list_path)
                        ->with('fields', $this_model->viewFields)
                        ->with('imageable', $controller->imageable)
                        ->render();

                if (\File::exists($full_list_path)) {//List file exists
                    \File::put($full_list_path, $list_view);
                }//E# if else statement
            }//E# if else statement

            /* Detailed View */
            //Create detailed file name
            $detailed_file_name = $controller->controller . 'DetailedView.php';

            //Full detailed path
            $full_detailed_path = $view_path . '/' . $detailed_file_name;

            //Template detailed path
            $template_detailed_path = \File::exists($view_path . '/' . 'detailedView.php') ? $controller->package . '::' . $controller->controller . '.detailedView' : 'views.detailedView';

            //Get detailed view
            $detailed_view = \View::make($template_detailed_path)
                    ->with('fields', $this_model->viewFields)
                    ->with('imageable', $controller->imageable)
                    ->render();

            if (\File::exists($full_detailed_path)) {//Detailed file exists
                \File::put($full_detailed_path, $detailed_view);
            }//E# if else statement
        }//E# foreach statement
    }

}

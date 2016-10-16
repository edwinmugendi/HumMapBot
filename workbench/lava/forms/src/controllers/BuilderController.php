<?php

namespace Lava\Forms;

use Carbon\Carbon;

/**
 * S# BuilderController() function
 * Builder controller
 * @author Edwin Mugendi
 */
class BuilderController extends FormsBaseController {

    //Controller
    public $controller = 'builder';

    /**
     * S# buildForm() function
     */
    public function buildForm($form_model) {

        $fields = array();
        foreach ($form_model->questions as $single_question) {
            $fields[snake_case(\Str::lower($single_question->name))] = 'string';
        }//E# foreach statement

        if (array_key_exists('gps', $fields)) {
            unset($fields['gps']);
            $fields['latitude'] = 'decimal';
            $fields['longitude'] = 'decimal';
        }//E# if statement

        $form_name = \Str::lower($form_model->name);

        //Build routes view
        $this->buildRouteView('lava', 'forms', $form_name);

        //Build view view
        $this->buildViewView($form_name);

        //Build model view
        $this->buildModelView($form_name, $fields);

        //Build controller view
        $this->buildControllerView($form_name, $fields);

        //Build language view
        $this->buildLangView($form_name, $fields);

        //Call clear compiled and domp autoload
        //\Artisan::call('clear-compiled');
        //\Artisan::call('dump-autoload');
        exec('php artisan clear-compiled && php artisan dump-autoload');
        //Build migration view
        $this->buildMigrationView('lava', 'forms', $form_name, $fields);

        //Build generator view
        $this->buildGeneratorView('lava', 'forms', $form_name);

    }

//E# buildForm() function

    /**
     * S# buildGeneratorView() function
     * 
     * Build route view
     * 
     * @param str $table_name Table name
     * @param array $fields Fields
     * 
     */
    private function buildGeneratorView($workbench, $package, $table_name) {
        $generator_controller = new \GeneratorController();

        $name_space = ucwords($workbench) . '\\' . ucwords($package) . '\\' . ucwords(camel_case($table_name)) . 'Controller';

        $generator_controller->controllers = array($name_space);

        $generator_controller->generateViews(true);

        return true;
    }

//E# buildGeneratorView() function

    /**
     * S# buildRouteView() function
     * 
     * Build route view
     * 
     * @param str $table_name Table name
     * @param array $fields Fields
     * 
     */
    private function buildRouteView($workbench, $package, $table_name) {
        //Route name
        $route_name = camel_case($table_name) . '.php';

        //Route path
        $route_path = dirname(__DIR__) . '/routes/' . $route_name;

        $camel_table_name = camel_case(\Str::lower($table_name));
        $snake_table_name = snake_case($camel_table_name);

        //Get route view
        $route_view = \View::make($this->package . '::' . $this->controller . '.' . camel_case($this->controller . '_RouteView'))
                ->with('package', $package)
                ->with('table_name', $table_name)
                ->with('camel_table_name', $camel_table_name)
                ->with('snake_table_name', $snake_table_name)
                ->with('workbench', $workbench)
                ->render();

        //Create route file
        \File::put($route_path, $route_view);

        //All routes path
        $all_route_path = dirname(__DIR__) . '/routes/all_form_routes.php';

        if (!exec('grep ' . escapeshellarg($route_name) . ' ' . $all_route_path)) {
            //Single route
            $single_route = 'require_once __DIR__ . \'/' . $route_name . '\';';

            // Append route file
            \File::append($all_route_path, $single_route);
        }//E# if statement

        return true;
    }

//E# buildRouteView() function

    /**
     * S# buildViewView() function
     * 
     * Build view view
     * 
     */
    private function buildViewView($table_name) {
        //Camel table name
        $camel_table_name = camel_case($table_name);

        //Detailed name
        $detailed_view_name = $camel_table_name . 'DetailedView.php';

        //List Single name
        $list_single_view_name = $camel_table_name . 'ListSingleView.php';

        //Post name
        $post_view_name = $camel_table_name . 'PostView.php';

        //List name
        $list_view_name = $camel_table_name . 'ListView.php';

        //Controller path
        $controller_view_path = dirname(__DIR__) . '/views/' . camel_case($table_name);

        if (!\File::isDirectory($controller_view_path)) {
            \File::makeDirectory($controller_view_path, 0775);
        }//E# if statement
        //View detailed path
        $view_path = $controller_view_path . '/' . $detailed_view_name;

        //Create detailed view
        \File::put($view_path, '');

        //View list single path
        $view_path = $controller_view_path . '/' . $list_single_view_name;

        //Create list single view
        \File::put($view_path, '');

        //View post path
        $view_path = $controller_view_path . '/' . $post_view_name;

        //Create post view
        \File::put($view_path, '');

        //View list path
        $view_path = $controller_view_path . '/' . $list_view_name;

        //Create list view
        \File::put($view_path, '');

        return true;
    }

//E# buildViewView() function

    /**
     * S# buildModelView() function
     * 
     * Build model view
     * 
     * @param str $table_name Table name
     * @param array $fields Fields
     * 
     */
    private function buildModelView($table_name, $fields) {
        //Model name
        $model_name = ucwords(camel_case(\Str::lower($table_name))) . 'Model';

        //Model name
        $model_full_name = $model_name . '.php';

        //Model path
        $model_path = dirname(__DIR__) . '/models/' . $model_full_name;

        //Get model view
        $model_view = \View::make($this->package . '::' . $this->controller . '.' . camel_case($this->controller . '_ModelView'))
                ->with('fields', $fields)
                ->with('table_name', $table_name)
                ->with('model_name', $model_name)
                ->render();

        //Create lang file
        \File::put($model_path, $model_view);

        //Change mode
        //chmod($lang_path, 0777);

        return true;
    }

//E# buildModelView() function

    /**
     * S# buildControllerView() function
     * 
     * Build controller view
     * 
     * @param str $table_name Table name
     * @param array $fields Fields
     * 
     */
    private function buildControllerView($table_name, $fields) {
        //Controller name
        $controller_name = ucwords(camel_case(\Str::lower($table_name))) . 'Controller';

        //Controller name
        $controller_full_name = $controller_name . '.php';

        //Controller path
        $controller_path = dirname(__DIR__) . '/controllers/' . $controller_full_name;

        //Get controller view
        $controller_view = \View::make($this->package . '::' . $this->controller . '.' . camel_case($this->controller . '_ControllerView'))
                ->with('fields', $fields)
                ->with('table_name', $table_name)
                ->with('controller_name', $controller_name)
                ->render();

        //Create lang file
        \File::put($controller_path, $controller_view);

        //Change mode
        //chmod($lang_path, 0777);

        return true;
    }

//E# buildControllerView() function

    /**
     * S# buildMigrationView() function
     * 
     * Build migration view
     * 
     * @param str $workbench Workbench
     * @param str $table_name Table name
     * @param array $fields Fields
     * 
     * 
     */
    private function buildMigrationView($workbench, $package, $table_name, $fields) {

        $migration_name = str_replace(' ', '_', \Str::lower('create_' . $package . ' ' . $table_name . '_table'));

        $migration_full_name = str_replace(' ', '_', '2016_10_05_123455_' . $migration_name . '.php');

        $migration_path = dirname(__DIR__) . '/migrations/' . $migration_full_name;

        //Get migration view
        $migration_view = \View::make($this->package . '::' . $this->controller . '.' . camel_case($this->controller . '_MigrationView'))
                ->with('fields', $fields)
                ->with('class_name', ucwords(camel_case($migration_name)))
                ->with('table_name', $table_name)
                ->render();

        //Create file
        \File::put($migration_path, $migration_view);

        //Change mode
        chmod($migration_path, 0777);

        //Run migrations
        \Artisan::call('migrate', [
            '--bench' => $workbench . '/' . $package
        ]);

        return true;
    }

//E# buildMigrationView() function

    /**
     * S# buildLangView() function
     * 
     * Build language view
     * 
     * @param str $table_name Table name
     * @param array $fields Fields
     * 
     */
    private function buildLangView($table_name, $fields) {
        //Lang name
        $lang_name = camel_case($table_name) . '.php';

        //Lang path
        $lang_path = dirname(__DIR__) . '/lang/en/' . $lang_name;

        //Get lang view
        $lang_view = \View::make($this->package . '::' . $this->controller . '.' . camel_case($this->controller . '_LangView'))
                ->with('fields', $fields)
                ->with('table_name', $table_name)
                ->render();

        //Create lang file
        \File::put($lang_path, $lang_view);

        //Change mode
        //chmod($lang_path, 0777);

        return true;
    }

//E# buildLangView() function
}

//E# BuilderController() function
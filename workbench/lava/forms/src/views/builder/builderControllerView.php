<?php echo '<?php'; ?>

namespace Lava\Forms;

/**
* S# <?php echo $controller_name; ?>() function
* <?php echo $controller_name; ?>
* @author Edwin Mugendi
*/
class <?php echo $controller_name; ?> extends FormsBaseController {

//Controller
public $controller = '<?php echo str_replace(' ', '_', \Str::lower($table_name)); ?>';

<?php if ($form_immageable): ?>
    //Imageable
    public $imageable = true;
<?php endif; ?>
/**
* S# injectDataSources() function
* @author Edwin Mugendi
* Inject data source. This are mainly select
* 
* @param array $dataSource Data source
*/
public function injectDataSources() {
//Get and set workflow options to data source
$this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');
}

//E# injectDataSources() function
}

//E# <?php echo $controller_name; ?>() function
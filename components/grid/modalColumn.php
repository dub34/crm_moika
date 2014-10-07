<?php

/**
 * @copyright Copyright &copy; v.kriuchkov
 * @package yii2-grid
 * @version 2.0.0
 */

namespace components\grid;

use Yii;
use Closure;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\base\InvalidConfigException;

/**
 * The ModalColumn show data in modal window
 *
 * @author v.kriuchkov
 * @since 1.0
 */
class ModalColumn extends DataColumn
{
    
    /**
     * @var array|Closure the configuration options for the [[\kartik\editable\Editable]] widget. If not set as an array,
     * this can be passed as a callback function of the signature: `function ($model, $key, $index)`, where:
     * - $model mixed is the data model
     * - $key mixed is the key associated with the data model
     * - $index integer is the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     */
    public $editableOptions = [];
    
    /**
     * @var boolean whether to refresh the grid on successful submission of editable
     */
    public $refreshGrid = false;
    
    /**
     * @var array the computed editable options
     */
    protected $_editableOptions = [];
    
    /**
     * Renders the data cell content.
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     *
     * @return string the rendering result
     * @throws InvalidConfigException
     */
    public function renderDataCellContent($model, $key, $index)
    {
        $this->_editableOptions = $this->editableOptions;
        if (!empty($this->editableOptions) && $this->editableOptions instanceof Closure) {
            $this->_editableOptions = call_user_func($this->editableOptions, $model, $key, $index);
        }
        if (!is_array($this->_editableOptions)) {
            $this->_editableOptions = [];
        }
        if ($this->grid->pjax && empty($this->_editableOptions['pjaxContainerId'])) {
            $this->_editableOptions['pjaxContainerId'] = $this->grid->pjaxSettings['options']['id'];
        }
        $strKey = $key;
        if (empty($key)) {
            throw new InvalidConfigException("Invalid or no primary key found for the grid data.");
        } elseif (!is_string($key) && !is_numeric($key)) {
            $strKey = serialize($key);
        }
        if ($this->attribute !== null) {
            $this->_editableOptions['model'] = $model;
            $this->_editableOptions['attribute'] = '[' . $index . ']' . $this->attribute;
        } elseif (empty($this->_editableOptions['name']) && empty($this->_editableOptions['model']) ||
            !empty($this->_editableOptions['model']) && empty($this->_editableOptions['attribute'])) {
            throw new InvalidConfigException("You must setup the 'attribute' for your EditableColumn OR set one of 'name' OR 'model' & 'attribute' in 'editableOptions' (Exception at index: '{$index}', key: '{$strKey}').");
        }
        $this->_editableOptions['displayValue'] = parent::renderDataCellContent($model, $key, $index);
        $params = Html::hiddenInput('editableIndex', $index) . Html::hiddenInput('editableKey', $strKey);
        if (empty($this->_editableOptions['beforeInput'])) {
            $this->_editableOptions['beforeInput'] = $params;
        } else {
            $this->_editableOptions['beforeInput'] .= $params;
        }
        if ($this->refreshGrid) {
            $view = $this->grid->getView();
            $grid = 'jQuery("#' . $this->grid->options['id'] . '")';
            $script =<<< JS
{$grid}.find('.kv-editable-input').each(function() {
    var \$input = $(this);
    \$input.on('editableSuccess', function(){
        {$grid}.yiiGridView("applyFilter");
    });
});
JS;
            $view->registerJs($script);
        }
        return Editable::widget($this->_editableOptions);
    }
}
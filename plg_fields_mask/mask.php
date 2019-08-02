<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.MASK
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::import('components.com_fields.libraries.fieldsplugin', JPATH_ADMINISTRATOR);

class PlgFieldsMask extends FieldsPlugin
{
    public function onCustomFieldsPrepareDom($field, DOMElement $parent, JForm $form)
    {
        $fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);

        if (!$fieldNode) {
            return $fieldNode;
        }

        JHtml::_('jquery.framework');

        $doc = JFactory::getDocument();
        $doc->addScript(JURI::root(true) . '/media/plg_fields_mask/js/jquery.mask.min.js', array('version' => 'auto'));
        $doc->addScriptDeclaration('
            jQuery(document).ready(function($){
                $(".mask-cep").mask("00000-000");
                $(".mask-phone").mask("0000-0000");
                $(".mask-cpf").mask("000.000.000-00");
                $(".mask-cnpj").mask("00.000.000/0000-00");
                $(".mask-money").mask("#.##0,00", {reverse: true});
                $(".mask-ip_address").mask("0ZZ.0ZZ.0ZZ.0ZZ", {
                    translation: {
                        "Z": {
                        pattern: /[0-9]/, optional: true
                    }
                }});
            });');

        $class = $fieldNode->getAttribute('class');
        $fieldNode->setAttribute('type', 'text');

        $typeMask = $field->fieldparams->get('type_mask', 'input');
        if ($typeMask == '0') {
            $fieldNode->setAttribute('class', $class . ' mask-input');
            $name = $fieldNode->getAttribute('name');
            $doc->addScriptDeclaration('
                jQuery(document).ready(function($){
                    $("[name=\'jform[com_fields][' . $name . ']\']").mask("' . $field->fieldparams->get('mask', '#') . '");
                });');
        } else {
            $fieldNode->setAttribute('class', $class . ' mask-' . $typeMask);
        }
        return $fieldNode;
    }
}

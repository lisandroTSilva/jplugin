<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.CPF
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::import('components.com_fields.libraries.fieldsplugin', JPATH_ADMINISTRATOR);

/**
 * Fields Integer Plugin
 *
 * @since  3.7.0
 */
class PlgFieldsCpf extends FieldsPlugin
{
    public function onCustomFieldsPrepareDom($field, DOMElement $parent, JForm $form)
    {
        $fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);

        if (!$fieldNode) {
            return $fieldNode;
        }

        JHtml::_('jquery.framework');

        $doc = JFactory::getDocument();
        $doc->addScript(JURI::root(true) . '/media/plg_fields_cpf/js/jquery.mask.min.js', array('version' => 'auto'));
        $doc->addScriptDeclaration('jQuery(document).ready(function($){
            $(".mask-cpf").mask("000.000.000-00", {reverse: true});
        });');

        $class = $fieldNode->getAttribute('class');
        $fieldNode->setAttribute('type', 'text');
        $fieldNode->setAttribute('class', $class . ' mask-cpf');

        return $fieldNode;
    }
}

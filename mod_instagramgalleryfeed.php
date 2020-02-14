<?php
/**
 * @package     Instagram feed
 * @subpackage  mod_instagramfeed
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;


//Carga el fichero helper.php
require_once dirname(__FILE__) . '/helper.php';

$items = modInstagramGalleryFeedHelper::getInstagramFeed($params); 


// Asignamos la vista a mostrar, por default
require JModuleHelper::getLayoutPath('mod_instagramfeed');
?>


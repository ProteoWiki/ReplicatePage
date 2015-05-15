<?php
/**
 * Copyright (C) 2011 Toni Hermoso Pulido <toniher@cau.cat>
 * http://www.cau.cat
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

//self executing anonymous function to prevent global scope assumptions
call_user_func( function() {

	$wgExtensionCredits['other'][] = array(
			'path' => __FILE__,
			'name' => 'ReplicatePage',
			'version' => '0.1', 
			'author' => array( 'Toniher' ), 
			'url' => 'https://mediawiki.org/wiki/Extension:ReplicatePage',
			'description' => 'replicatepage-desc',
	);

	
	// i18n
	$GLOBALS['wgMessagesDirs']['ReplicatePage'] = __DIR__ . '/i18n';
	$GLOBALS['wgExtensionMessagesFiles']['ReplicatePage'] = __DIR__ . '/ReplicatePage.i18n.php';
	$GLOBALS['wgExtensionMessagesFiles']['ReplicatePageMagic'] = __DIR__ . '/ReplicatePage.i18n.magic.php';

	# View file referencing
	$GLOBALS['wgAutoloadClasses']['ReplicatePage'] = __DIR__ . 'ReplicatePage_body.php';
	$GLOBALS['wgAutoloadClasses']['ApiReplicatePage'] = __DIR__ . 'ReplicatePage.api.php';

	$GLOBALS['wgResourceModules']['ext.ReplicatePage'] = array(
		'localBasePath' => dirname( __FILE__ ),
		'scripts' => array( 'js/replicatePage.js' ),
		'remoteExtPath' => 'ReplicatePage'
	);

	// TODO - Change
	$wgAjaxExportList[] = 'ReplicatePage::executeReplicate';

	// api modules
	$GLOBALS['wgAPIModules']['replicatepage'] = 'ApiReplicatePage';
	
	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = 'wfRegisterReplicatePage';


});

function wfRegisterReplicatePage( $parser ) {
	$parser->setFunctionHook( 'ReplicatePage', 'ReplicatePage::renderLink', SFH_OBJECT_ARGS  );
	return true;
}


<?php

if (!defined('MEDIAWIKI')) { die(-1); } 

class ReplicatePage {
	
	public static function renderLink ( $parser, $frame, $args ) {
		
		if ( isset($args[0]) ) {
			
			global $wgOut;
			$wgOut->addModules( 'ext.ReplicatePage' );
			
			$reload = 0;

			$endtext = $frame->expand( $args[0] );

			# Origin is set
			if ( isset($args[1]) ) {
				
				$origintext = $frame->expand( $args[1] );
				if ($origintext == '') {
					$origintext=$parser->getTitle()->getText();
				}
			}

			if ( isset($args[2]) ) {

				if ( strpos( $args[2], "reload" ) > -1 ) {
					$reload = "true";
				} else {
					$reload = "false";
				}

			}
			
			# Origin is current
			else {
				$origintext=$parser->getTitle()->getText();
			}	
					
			
			$str = Html::rawElement( 'a', array( 'href' => "#", 'class' => "replicate-link", 'data-replicate-target' => $endtext, 'data-replicate-source' => $origintext, 'data-replicate-reload' => $reload ), "Replicate" );
			return $parser->insertStripItem( $str, $parser->mStripState );
		}
		
		else { return ""; }

	}
	
	

	public static function executeReplicate ( $origintext, $endtext ) {

		# 2 params ( End and Origin ) 
		if ( isset( $origintext ) && isset( $endtext ) ) {
			
			$origin = Title::newFromText( $origintext ); 
			$end = Title::newFromText( $endtext );
			
			$wikipage = WikiPage::factory( $origin );
			$content = $wikipage->getText();
			
			$wikipageend = WikiPage::factory( $end );
			
			$wikipageend->doEdit( $content, "Replicating");
			
			return "OK";
		}
		
		else {
			
			return "KO";
		}

	}

}


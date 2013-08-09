<?php
namespace samson\minify;

use samson\minify\JSMin;

use samson\core\ExternalModule;
use samson\resourcerouter;

/**
 * Интерфейс для подключения модуля в ядро фреймворка SamsonPHP
 *
 * @package SamsonPHP
 * @author Vitaly Iegorov <vitalyiegorov@gmail.com>
 * @author Nikita Kotenko <nick.w2r@gmail.com>
 * @version 0.1
 */
class SamsonLessConnector extends ExternalModule
{
	/** Идентификатор модуля */
	protected $id = 'minify'; 	
	
	/** Список модулей от которых завист данный модуль */
	protected $requirements = array
	(
		'resourcer'	
	);
	
	/**	@see ModuleConnector::init() */
	public function init( array $params = array() )
	{	
		// Pointer to resourcerouter			
		$rr = m('resourcer');	
		try 
		{
			if( isset($rr->updated['js']))
			{
				// Запишем новое содержание JS
				file_put_contents( $rr->updated['js'], JSMin::minify( file_get_contents($rr->updated['js']) ) );			
			}			
			if( isset($rr->updated['css']))
			{
				// Запишем новое содержание JS
				file_put_contents( $rr->updated['css'], CSSMin::process( file_get_contents($rr->updated['css']) ) );
			}			
		}
		catch( Exception $e){ e('Error minifying resource: '.$e->getMessage()); }
		
		// Вызовем родительский метод
		parent::init( $params );				
	}	
}
<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjPropertyFeatureModel extends pjAppModel
{
	protected $primaryKey = NULL;
	
	protected $table = 'properties_features';
	
	protected $schema = array(
		array('name' => 'property_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'feature_id', 'type' => 'int', 'default' => ':NULL')
	);
	
	public static function factory($attr=array())
	{
		return new pjPropertyFeatureModel($attr);
	}
}
?>
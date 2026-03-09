<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjPropertyModel extends pjAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'properties';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'type_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'owner_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'created', 'type' => 'datetime', 'default' => ':NOW()'),
		array('name' => 'modified', 'type' => 'datetime', 'default' => ':NOW()'),
		array('name' => 'views', 'type' => 'int', 'default' => '0'),
		array('name' => 'prints', 'type' => 'int', 'default' => '0'),
		array('name' => 'sents', 'type' => 'int', 'default' => '0'),
		array('name' => 'for', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'is_featured', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'used_free', 'type' => 'enum', 'default' => 'F'),
		array('name' => 'status', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'ref_id', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'special', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'expire', 'type' => 'date', 'default' => ':NULL'),
		array('name' => 'last_extend', 'type' => 'enum', 'default' => 'free'),
		array('name' => 'added_by', 'type' => 'enum', 'default' => 'other'),
		array('name' => 'bedrooms', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'bathrooms', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'year_built', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'lot', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'price_per', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'floor_area', 'type' => 'float', 'default' => ':NULL'),
		array('name' => 'floor_plan_filename', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'floor_plan_filepath', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'floor_plan_mime', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'floor_plan_hash', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'show_googlemap', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'address_country', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'address_state', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'address_city', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'address_1', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'address_2', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'address_zip', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'lat', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'lng', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'owner_show', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'owner_name', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'owner_phone', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'owner_email', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'owner_fax', 'type' => 'varchar', 'default' => ':NULL')
	);
	
	public $i18n = array('title', 'discription', 'meta_title', 'meta_keywords', 'meta_description', 'address_1', 'google_address', 'address_city');
	
	public static function factory($attr=array())
	{
		return new pjPropertyModel($attr);
	}
	
	public function getLastID()
	{
		$id = 1;
		$arr = $this->orderBy("id DESC")->limit(1)->findAll()->getData();
		if(count($arr) > 0)
		{
			$id = $arr[0]['id'] + 1;
		}
		return $id;
	}
}
?>
<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminProperties extends pjAdmin
{
	private $imageFiles = array('small_path', 'medium_path', 'large_path', 'source_path');
	
	public function pjActionCheckRefId()
	{
		$this->setAjax(true);
		
		if ($this->isXHR() && isset($_GET['ref_id']))
		{
			$pjPropertyModel = pjPropertyModel::factory();
			if (isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				$pjPropertyModel->where('t1.id !=', $_GET['id']);
			}
			echo $pjPropertyModel->where('t1.ref_id', $_GET['ref_id'])->findCount()->getData() == 0 ? 'true' : 'false';
		}
		exit;
	}
	
	public function pjActionCreate()
	{
		$this->checkLogin();
		
		if ($this->isAdmin() || $this->isEditor() || ($this->isOwner() && $this->option_arr['o_allow_add_property'] == 'Yes'))
		{
			if (isset($_POST['property_create']))
			{
				$data = array();
				if (isset($_POST['expire']) && $_POST['status'] == 'E')
				{
					$data['expire'] = pjUtil::formatDate($_POST['expire'], $this->option_arr['o_date_format']);
				}else{
					unset($_POST['expire']);
				}
				$data['last_extend'] = 'free';
				if ($this->isOwner())
				{
					$data['owner_id'] = $this->getUserId();
					$data['status'] = 'F';
					$data['is_featured'] = 'F';
					$data['added_by'] = 'owner';
					$data['expire'] = date("Y-m-d", strtotime("-1 day"));
				}
				
				$data = array_merge($_POST, $data);
				
				$pjPropertyModel = pjPropertyModel::factory();
				if (!$pjPropertyModel->validates($data))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionCreate&err=1");
				}
				
				$id = $pjPropertyModel->setAttributes($data)->insert()->getInsertId();
				
				if ($id !== false && (int) $id > 0)
				{
					if (isset($_POST['i18n']))
					{
						pjMultiLangModel::factory()->saveMultiLang($_POST['i18n'], $id, 'pjProperty');
					}
					$this->pjActionSendNotification($id);
					
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionUpdate&id=" . $id . "&tab_id=tabs-1");
				} else {
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionCreate&err=1");
				}
			}

			if ($this->isOwner())
			{
				$this->set('period_arr', pjPeriodModel::factory()->orderBy('t1.days ASC')->findAll()->getData());
			}
			
			$type_arr = pjTypeModel::factory()->select('t1.*, t2.content AS name')
				->join('pjMultiLang', "t2.model='pjType' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'")
				->where('t1.status', 'T')->orderBy('name ASC')->findAll()->getData();
			$this->set('type_arr', pjSanitize::clean($type_arr));
	
			$user_arr = pjUserModel::factory()->where('role_id', 3)->findAll()->getData();
			$this->set('user_arr', pjSanitize::clean($user_arr));
			
			$this->set('ref_id', pjPropertyModel::factory()->getLastID());
			
			$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
			$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
				
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdminProperties.js');
		} else {
			$this->set('status', 2);
		}
	}
		
	public function pjActionDeleteProperty()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$response = array();
			if (pjPropertyModel::factory()->setAttributes(array('id' => $_GET['id']))->erase()->getAffectedRows() == 1)
			{
				pjMultiLangModel::factory()->where('model', 'pjProperty')->where('foreign_id', $_GET['id'])->eraseAll();
				
				pjPropertyFeatureModel::factory()->where('property_id', $_GET['id'])->eraseAll();
				
				$pjGalleryModel = pjGalleryModel::factory();
				$arr = $pjGalleryModel->where('foreign_id', $_GET['id'])->findAll()->getData();
				if (count($arr) > 0)
				{
					foreach ($arr as $item)
					{
						foreach ($this->imageFiles as $file)
						{
							@clearstatcache();
							if (!empty($item[$file]) && is_file($item[$file]))
							{
								@unlink($item[$file]);
							}
						}
					}
					$pjGalleryModel->eraseAll();
				}
				$response['code'] = 200;
			} else {
				$response['code'] = 100;
			}
			pjAppController::jsonResponse($response);
		}
		exit;
	}
	
	public function pjActionDeletePropertyBulk()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (isset($_POST['record']) && count($_POST['record']) > 0)
			{
				pjPropertyModel::factory()->whereIn('id', $_POST['record'])->eraseAll();
				pjMultiLangModel::factory()->where('model', 'pjProperty')->whereIn('foreign_id', $_POST['record'])->eraseAll();
				
				pjPropertyFeatureModel::factory()->whereIn('property_id', $_POST['record'])->eraseAll();
				
				$arr = pjGalleryModel::factory()->whereIn('foreign_id', $_POST['record'])->findAll()->getData();
				if (count($arr) > 0)
				{
					pjGalleryModel::factory()->whereIn('foreign_id', $_POST['record'])->eraseAll();
					foreach ($arr as $item)
					{
						foreach ($this->imageFiles as $file)
						{
							@clearstatcache();
							if (!empty($item[$file]) && is_file($item[$file]))
							{
								@unlink($item[$file]);
							}
						}
					}
				}
			}
		}
		exit;
	}
	
	public function pjActionGetLocale()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (isset($_GET['locale']) && (int) $_GET['locale'] > 0)
			{
				pjAppController::setFields($_GET['locale']);
				
				$this->set('type_arr', pjTypeModel::factory()->select('t1.*, t2.content AS name')
					->join('pjMultiLang', "t2.model='pjType' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$_GET['locale']."'", 'inner')
					->where('t1.status', 'T')->orderBy('name ASC')->findAll()->getData()
				);
			}
		}
	}
	
	public function pjActionExpireProperty()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (isset($_POST['record']) && count($_POST['record']) > 0)
			{
				pjPropertyModel::factory()->whereIn('id', $_POST['record'])->modifyAll(array('expire' => ':DATE_ADD(`expire`, INTERVAL 30 DAY)'));
			} elseif (isset($_GET['id']) && (int) $_GET['id'] > 0) {
				pjPropertyModel::factory()->where('id', $_GET['id'])->limit(1)->modifyAll(array('expire' => ':DATE_ADD(`expire`, INTERVAL 30 DAY)'));
			}
		}
		exit;
	}
	
	public function pjActionGetProperty()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjPropertyModel = pjPropertyModel::factory()
				->join('pjUser', 't2.id=t1.owner_id', 'left')
				->join('pjMultiLang', "t3.model='pjType' AND t3.foreign_id=t1.type_id AND t3.field='name' AND t3.locale='".$this->getLocaleId()."'", 'left')
				->join('pjMultiLang', "t4.model='pjProperty' AND t4.foreign_id=t1.id AND t4.field='address_city' AND t4.locale='".$this->getLocaleId()."'", 'left')
				->join('pjMultiLang', "t5.model='pjProperty' AND t5.foreign_id=t1.id AND t5.field='address_1' AND t5.locale='".$this->getLocaleId()."'", 'left');
			
			if (isset($_GET['status']) && !empty($_GET['status']))
			{
				if($_GET['status'] == 'T')
				{
					$pjPropertyModel->where("(t1.status = 'T' OR (t1.status = 'E' AND t1.expire >= CURDATE()))");
				}else{
					$pjPropertyModel->where("(t1.status = 'F' OR (t1.status = 'E' AND t1.expire < CURDATE()))");
				}
			}
			if (isset($_GET['q']) && !empty($_GET['q']))
			{
				$q = pjObject::escapeString($_GET['q']);
				$pjPropertyModel->where('t1.ref_id LIKE', "%$q%");
				$pjPropertyModel->orWhere("t1.id IN (SELECT t8.foreign_id FROM `".pjMultiLangModel::factory()->getTable()."` AS t8 WHERE t8.model='pjProperty' AND t8.locale='".$this->getLocaleId()."' AND (t8.`field` = 'title') AND t8.`content` LIKE '%$q%')");
			}
			if (isset($_GET['keyword']))
			{
				if($_GET['keyword'] != '')
				{
					$keyword = pjObject::escapeString($_GET['keyword']);
					$pjPropertyModel->where("t1.id IN (SELECT t8.foreign_id FROM `".pjMultiLangModel::factory()->getTable()."` AS t8 WHERE t8.model='pjProperty' AND t8.locale='".$this->getLocaleId()."' AND (t8.`field` = 'description' OR t8.`field` = 'title') AND t8.`content` LIKE '%$keyword%')");
				}
			}
			if (isset($_GET['is_featured']) && $_GET['is_featured'] != '')
			{
				$pjPropertyModel->where('t1.is_featured', $_GET['is_featured']);
			}
			if ($this->isOwner())
			{
				$pjPropertyModel->where('t1.owner_id', $this->getUserId());
			} else {
				if (isset($_GET['owner_id']) && (int) $_GET['owner_id'] > 0)
				{
					$pjPropertyModel->where('t1.owner_id', $_GET['owner_id']);
				}
			}
			if (isset($_GET['type_id']) && (int) $_GET['type_id'] > 0)
			{
				$pjPropertyModel->where('t1.type_id', $_GET['type_id']);
			}
			if (isset($_GET['address_country']) && (int) $_GET['address_country'] > 0)
			{
				$pjPropertyModel->where('t1.address_country', $_GET['address_country']);
			}
			if (isset($_GET['ref_id']) && !empty($_GET['ref_id']))
			{
				$q = pjObject::escapeString($_GET['ref_id']);
				$pjPropertyModel->where('t1.ref_id LIKE', "%$q%");
			}
			if (isset($_GET['address_state']))
			{
				if($_GET['address_state'] != '')
				{
					$state = pjObject::escapeString($_GET['address_state']);
					$pjPropertyModel->where("t1.address_state LIKE '%$state%'");
				}
			}
			if (isset($_GET['address_city']))
			{
				if($_GET['address_city'] != '')
				{
					$city = pjObject::escapeString($_GET['address_city']);
					$pjPropertyModel->where("t4.content LIKE '%$city%'");
				}
			}
			
			$column = 'id';
			$direction = 'DESC';
			if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC')))
			{
				$column = $_GET['column'];
				$direction = strtoupper($_GET['direction']);
			}
			
			$total = $pjPropertyModel->findCount()->getData();
			$rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
			$pages = ceil($total / $rowCount);
			$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}
			$data = array();
			$arr = $pjPropertyModel->select(sprintf('t1.id, t1.ref_id, t1.for, t1.expire, t1.status, t1.type_id, t1.added_by, t1.price, t1.price_per, t3.content AS type_title, t4.content AS address_city, t5.content AS address_1, t1.owner_id, t2.name AS owner_name,
				(SELECT `small_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `image`', pjGalleryModel::factory()->getTable()))
				->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();

			$types = __('types', true);
			$price_per = __('price_per', true);
			foreach($arr as $k => $v)
			{
				$price = array();
				$v['ref_id'] = pjSanitize::clean($v['ref_id']);
				$v['is_expired'] = 0;
				if($v['expire'] < date('Y-m-d'))
				{
					$v['is_expired'] = 1;					
				}
				$v['expire'] = pjUtil::formatDate(date('Y-m-d', strtotime($v['expire'])), 'Y-m-d', $this->option_arr['o_date_format']);
				$v['type_title'] = $v['type_title'] . ' ' . mb_strtolower($types[$v['for']], 'UTF-8');
				if(!empty($v['price']))
				{
					if(is_numeric($v['price']))
					{
						$price[] = pjUtil::formatCurrencySign($v['price'], $this->option_arr['o_currency']);
					}else{
						$price[] = pjSanitize::html($v['price']);
					}
					if($v['for'] == 'rent' && !empty($v['price_per']))
					{
						$price[] = $price_per[$v['price_per']];
					}
				}
				$v['price'] = join('<br/>', $price);
				$data[$k] = $v;
			}	
			
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionGetGeocode()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$geo = pjAdminProperties::pjActionGeocode($_POST, $this->option_arr);
			$response = array('code' => 100);
			if (isset($geo['lat']) && !is_array($geo['lat']))
			{
				$response = $geo;
				$response['code'] = 200;
			}
			pjAppController::jsonResponse($response);
		}
		exit;
	}
	
	private static function pjActionGeocode($post, $option_arr)
	{
		$address = array();
		
		$address_1 = '';
		$address_city = '';
		
		$address[] = $post['address_zip'];
		$address[] = $post['address_state'];
		
		$locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file')
			->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
			->where('t2.file IS NOT NULL')
			->orderBy('t1.sort ASC')->findAll()->getData();
		
		foreach($locale_arr as $k => $v)
		{
			if($v['is_default'] == 1)
			{
				$address_1 = $post['i18n'][$v['id']]['address_1'];
				$address_city = $post['i18n'][$v['id']]['address_city'];
			}
		}
		
		$address[] = $address_1;
		$address[] = $address_city;

		foreach ($address as $key => $value)
		{
			$tmp = preg_replace('/\s+/', '+', $value);
			$address[$key] = $tmp;
		}
		$_address = join(",+", $address);

		$api_key_str = isset($option_arr['o_google_map_api']) && !empty($option_arr['o_google_map_api']) ? 'key=' . $option_arr['o_google_map_api'] . '&' : '';
		$gfile = "https://maps.googleapis.com/maps/api/geocode/json?".$api_key_str."address=".$_address;
		$Http = new pjHttp();
		$response = $Http->request($gfile)->getResponse();

		$geoObj = pjAppController::jsonDecode($response);
		
		$data = array();
		$geoArr = (array) $geoObj;
		if ($geoArr['status'] == 'OK')
		{
			$geoArr['results'][0] = (array) $geoArr['results'][0];
			$geoArr['results'][0]['geometry'] = (array) $geoArr['results'][0]['geometry'];
			$geoArr['results'][0]['geometry']['location'] = (array) $geoArr['results'][0]['geometry']['location'];
			
			$data['lat'] = $geoArr['results'][0]['geometry']['location']['lat'];
			$data['lng'] = $geoArr['results'][0]['geometry']['location']['lng'];
		} else {
			$data['lat'] = NULL;
			$data['lng'] = NULL;
		}
		return $data;
	}
	
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if ($this->isAdmin() || $this->isEditor() || $this->isOwner())
		{
			$user_arr = pjUserModel::factory()->where('role_id', 3)->findAll()->getData();
			$this->set('user_arr', pjSanitize::clean($user_arr));
			
			$country_arr = pjCountryModel::factory()->select('t1.*, t2.content AS name')
				->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
				->where('status', 'T')->orderBy('name ASC')->findAll()->getData();
			$this->set('country_arr', pjSanitize::clean($country_arr));
			
			$type_arr = pjTypeModel::factory()->select('t1.*, t2.content AS name')
				->join('pjMultiLang', "t2.model='pjType' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
				->where('status', 'T')->orderBy('name ASC')->findAll()->getData();
			$this->set('type_arr', pjSanitize::clean($type_arr));
			
			$this->appendJs('chosen.jquery.js', PJ_THIRD_PARTY_PATH . 'chosen/');
			$this->appendCss('chosen.css', PJ_THIRD_PARTY_PATH . 'chosen/');
			
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjAdminProperties.js');
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionExtend()
	{
		$this->checkLogin();
		
		if ($this->isAdmin() || $this->isEditor() || ($this->isOwner() && $this->option_arr['o_allow_add_property'] == 'Yes'))
		{
			if (isset($_POST['extend']))
			{
				$pjPropertyModel = pjPropertyModel::factory();
			
				$arr = $pjPropertyModel->find($_POST['id'])->getData();
				if($arr['used_free'] == 'F')
				{
					$period_arr = pjPeriodModel::factory()->find($_POST['period_id'])->getData();
					if (count($arr) > 0 && count($period_arr) > 0)
					{
						$current = time();
						if ($arr['last_extend'] == 'paid' && !empty($arr['expire']) && $arr['expire'] != '0000-00-00')
						{
							$current = strtotime($arr['expire']);
						}
						
						$pjPropertyModel->set('id', $arr['id'])->modify(array(
							'status' => 'E',
							'last_extend' => 'free',
							'used_free' => 'T',
							'expire' => date("Y-m-d", $current + (int) $period_arr['days'] * 86400)
						));
					}
				}else{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionPayment&id=".$_POST['id']."&err=AP20");
				}
			}
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionIndex&err=AP10");
			
		} else {
			$this->set('status', 2);
		}
	}

	public function pjActionCheckFreePlan()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$response = array('code' => 100);
			if(isset($_POST['id']) && (int) $_POST['id'] > 0)
			{
				$arr = pjPropertyModel::factory()->find($_POST['id'])->getData();
				if($arr['used_free'] == 'F')
				{
					$response = array('code' => 200);
				}else{
					$response = array('code' => 101);
				}
			}
			pjAppController::jsonResponse($response);
		}
		exit;
	}
	
	public function pjActionPayment()
	{
		$this->checkLogin();
		
		if ($this->isAdmin() || $this->isEditor() || $this->isOwner())
		{
			$arr = pjPropertyModel::factory()
				->select('t1.*, t2.content AS property_title')
				->join('pjMultiLang', "t2.model='pjProperty' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left')
				->find($_GET['id'])->getData();
				
			if (count($arr) === 0)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionIndex&err=AP08");
			} elseif ($this->isOwner() && $arr['owner_id'] != $this->getUserId()) {
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionIndex&err=AP09");
			}
			$this->set('arr', $arr);
			$this->set('period_arr', pjPeriodModel::factory()->orderBy('t1.days ASC')->findAll()->getData());
			
			$this->appendJs('bootstrap.min.js', PJ_THIRD_PARTY_PATH . 'bootstrap/js/');
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdminProperties.js');
		} else {
			$this->set('status', 2);
		}
	}
		
	public function pjActionStatusProperty()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (isset($_POST['record']) && count($_POST['record']) > 0 && isset($_GET['status']) && in_array($_GET['status'], array('T', 'F', 'E')))
			{
				pjPropertyModel::factory()->whereIn('id', $_POST['record'])->modifyAll(array('status' => $_GET['status']));
			}
		}
		exit;
	}
	
	public function pjActionSaveProperty()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjPropertyModel = pjPropertyModel::factory();
			if (!in_array($_POST['column'], $pjPropertyModel->i18n))
			{
				if (in_array($_POST['column'], array('expire')))
				{
					$_POST['value'] = pjUtil::formatDate($_POST['value'], $this->option_arr['o_date_format']);
				}
				$value = $_POST['value'];
				
				$can = true;
				if($_POST['column'] == 'ref_id')
				{
					if($pjPropertyModel->where('t1.ref_id', $_POST['value'])->findCount()->getData() > 0)
					{
						$can = false;
					}
				}
				if($can == true)
				{
					$pjPropertyModel->reset()->where('id', $_GET['id'])->limit(1)->modifyAll(array($_POST['column'] => $value));
				}
			} else {
				pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($_POST['column'] => $_POST['value'])), $_GET['id'], 'pjProperty');
			}
		}
		exit;
	}
	
	public function pjActionUpdate()
	{
		$this->checkLogin();
			
		if ($this->isAdmin() || $this->isEditor() || $this->isOwner())
		{
			$PropertyFeatureModel = new pjPropertyFeatureModel();
				
			if (isset($_POST['property_update']))
			{
				$arr = pjPropertyModel::factory()->find($_POST['id'])->getData();
				if (empty($arr))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionIndex&err=AP08");
				}

				$err = NULL;
				$data = array();
				
				if ($this->isOwner())
				{
					if ($arr['owner_id'] != $this->getUserId())
					{
						pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionIndex&err=AP09");
					}
					unset($_POST['owner_id']);
					$data['owner_id'] = $arr['owner_id'];
					$data['expire'] = $arr['expire'];
					$data['status'] = $arr['status'];
				}
				if($_POST['for'] == 'sale')
				{
					unset($_POST['price_per']);
				}
				$data['modified'] = date("Y-m-d H:i:s");
				if (!$this->isOwner())
				{
					if($_POST['status'] == 'E')
					{
						$data['expire'] = pjUtil::formatDate($_POST['expire'], $this->option_arr['o_date_format']);
					}else{
						$data['expire'] = ":NULL";
					}
				}
				
				$geo = array();
				if (!isset($_POST['lat']) || empty($_POST['lat']) || !isset($_POST['lng']) || empty($_POST['lng']))
				{
					$geo = pjAdminProperties::pjActionGeocode($_POST, $this->option_arr);
				}

				$is_writable = false;
				if (isset($_FILES['file']) && !empty($_FILES['file']['tmp_name']))
				{
					$has_error = false;
					if($_FILES['file']['error'] != 4 && $_FILES['file']['error'] != 0)
					{
						$has_error = true;
					}
					if (is_writable('app/web/upload/files'))
					{
						$is_writable = true;
					}else{
						$has_error = true;
					}
					if($has_error == false)
					{
						if(!empty($arr['floor_plan_filepath']))
						{
							@unlink(PJ_INSTALL_PATH . $arr['floor_plan_filepath']);
						}
						$handle = new pjUpload();
						if ($handle->load($_FILES['file']))
						{
							$hash = md5(uniqid(rand(), true));
							$file_ext = $handle->getExtension();
							$file_path = PJ_UPLOAD_PATH . 'files/' . $_POST['id'] . "_" . $hash . '.' . $file_ext;
							if($handle->save($file_path))
							{
								$data['floor_plan_filepath'] = $file_path;
								$data['floor_plan_filename'] = $_FILES['file']['name'];
								$data['floor_plan_mime'] = $_FILES['file']['type'];
								$data['floor_plan_hash'] = $hash;
							}
						}
					}
				}
				$data['floor_area'] = !empty($_POST['floor_area']) ? floatval($_POST['floor_area']) : ':NULL';
				
				$pjPropertyModel = pjPropertyModel::factory();
				$post = array_merge($_POST, $data, $geo);
				
				if (!$pjPropertyModel->validates($post))
				{
					pjUtil::redirect(sprintf("%s?controller=pjAdminProperties&action=pjActionUpdate&id=%u&locale=%u&tab_id=%s&err=AP02", $_SERVER['PHP_SELF'], $_POST['id'], $_POST['locale'], $_POST['tab_id']));
				}
				
				$pjPropertyModel->set('id', $_POST['id'])->modify($post);

				if (isset($_POST['i18n']))
				{
					pjMultiLangModel::factory()->updateMultiLang($_POST['i18n'], $_POST['id'], 'pjProperty');
				}
				
				pjPropertyFeatureModel::factory()->where('property_id', $_POST['id'])->eraseAll();
				if (isset($_POST['feature']) && is_array($_POST['feature']) && count($_POST['feature']) > 0)
				{
					$PropertyFeatureModel->begin();
					foreach ($_POST['feature'] as $feature_id)
					{
						$PropertyFeatureModel->setAttributes(array(
							'property_id' => $_POST['id'],
							'feature_id' => $feature_id
						))->insert();
					}
					$PropertyFeatureModel->commit();
				}
				if($is_writable == true)
				{
					$err = "AP01";
				}else{
					$err = "AP10";
				}
				pjUtil::redirect(sprintf("%s?controller=pjAdminProperties&action=pjActionUpdate&id=%u&locale=%u&tab_id=%s&err=%s", $_SERVER['PHP_SELF'], $_POST['id'], $_POST['locale'], $_POST['tab_id'], $err));
				
			} else {
				$arr = pjPropertyModel::factory()
					->select("t1.*")
					->find($_GET['id'])->getData();
				
				if (count($arr) === 0)
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionIndex&err=AP08");
				}
				if ($this->isOwner() && $arr['owner_id'] != $this->getUserId())
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminProperties&action=pjActionIndex&err=AP09");
				}
				$arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($arr['id'], 'pjProperty');
				$this->set('arr', $arr);
									
				$type_arr = pjTypeModel::factory()->select('t1.*, t2.content AS name')
					->join('pjMultiLang', "t2.model='pjType' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
					->where('status', 'T')->orderBy('name ASC')->findAll()->getData();
				$this->set('type_arr', pjSanitize::clean($type_arr));
				
				$this->set('gallery_arr', pjGalleryModel::factory()->where('foreign_id', $arr['id'])->findAll()->getData());
				
				$pjFeatureModel = pjFeatureModel::factory();
				$property_feature_arr = $pjFeatureModel->select('t1.*, t2.content AS name')
					->join('pjMultiLang', "t2.model='pjFeature' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
					->where('status', 'T')->where('category_id', 2)->orderBy('name ASC')->findAll()->getData();

				$this->set('property_feature_arr', pjSanitize::clean($property_feature_arr));
				$community_feature_arr = $pjFeatureModel->reset()->select('t1.*, t2.content AS name')
					->join('pjMultiLang', "t2.model='pjFeature' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
					->where('status', 'T')->where('category_id', 1)->orderBy('name ASC')->findAll()->getData();
				$this->set('community_feature_arr', pjSanitize::clean($community_feature_arr));
				
				$country_arr = pjCountryModel::factory()->select('t1.*, t2.content AS name')
					->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
					->where('status', 'T')->orderBy('name ASC')->findAll()->getData();
				$this->set('country_arr', pjSanitize::clean($country_arr));
				
				$user_arr = pjUserModel::factory()->where('status', 'T')->findAll()->getData();
				$this->set('user_arr', pjSanitize::clean($user_arr));
				
				$locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file')
					->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
					->where('t2.file IS NOT NULL')
					->orderBy('t1.sort ASC')->findAll()->getData();
				
				$lp_arr = array();
				foreach ($locale_arr as $item)
				{
					$lp_arr[$item['id']."_"] = $item['file']; 
				}
				$this->set('lp_arr', $locale_arr);
				$this->set('locale_str', pjAppController::jsonEncode($lp_arr));
			
				$property_feature_id_arr = pjPropertyFeatureModel::factory()->where('t1.property_id', $_GET['id'])->findAll()->getDataPair('feature_id', 'feature_id');
				$this->set('property_feature_id_arr', $property_feature_id_arr);
				
				# TinyMCE
				$this->appendJs('tinymce.min.js', PJ_THIRD_PARTY_PATH . 'tinymce/');
				
				# jQuery Fancybox
				$this->appendJs('jquery.fancybox.pack.js', PJ_THIRD_PARTY_PATH . 'fancybox/js/');
				$this->appendCss('jquery.fancybox.css', PJ_THIRD_PARTY_PATH . 'fancybox/css/');
				
				# Gallery plugin
				$this->appendCss('pj-gallery.css', pjObject::getConstant('pjGallery', 'PLUGIN_CSS_PATH'));
				$this->appendJsFromPlugin('ajaxupload.js', 'ajaxupload', 'pjGallery');
				$this->appendJs('jquery.gallery.js', pjObject::getConstant('pjGallery', 'PLUGIN_JS_PATH'));
				
				$this->appendJs('chosen.jquery.js', PJ_THIRD_PARTY_PATH . 'chosen/');
				$this->appendCss('chosen.css', PJ_THIRD_PARTY_PATH . 'chosen/');
				
				$api_key_str = isset($this->option_arr['o_google_map_api']) && !empty($this->option_arr['o_google_map_api']) ? 'key=' . $this->option_arr['o_google_map_api'] . '&' : '';
				
				$this->appendJs('', 'https://maps.google.com/maps/api/js?'.$api_key_str.'libraries=places&region=uk&language=en', true);
				
				$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
				$this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
				$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendJs('pjAdminProperties.js');
			}
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionXMLFeed()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			if(isset($_POST['xml_feed']))
			{
				$pjPasswordModel = pjPasswordModel::factory();
				$password = md5($_POST['password'].PJ_SALT);
				$arr = $pjPasswordModel
					->where("t1.password", $password)
					->limit(1)
					->findAll()
					->getData();
				if (count($arr) != 1)
				{
					$pjPasswordModel->setAttributes(array('password' => $password))->insert();
				}
				$this->set('password', $password);
			}
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdminProperties.js');
		} else {
			$this->set('status', 2);
		}
	}
	public function pjActionGetXMLFeed()
	{
		$this->setLayout('pjActionEmpty');
		
		if(!isset($_GET['p']) && !isset($_GET['sortby']))
		{
			__('lblFeedURLInvalid');exit;
		}
		$access = true;
		if(isset($_GET['p']))
		{
			$pjPasswordModel = pjPasswordModel::factory();
			$arr = $pjPasswordModel
				->where('t1.password', $_GET['p'])
				->limit(1)
				->findAll()
				->getData();
			if (count($arr) != 1)
			{
				$access = false;
			}
		}else{
			$access = false;
		}
		if(isset($_GET['sortby']))
		{
			if(!in_array($_GET['sortby'], array('added','updated','expired')))
			{
				$access = false;
			}
		}
		if(isset($_GET['direction']))
		{
			if(!in_array(strtoupper($_GET['direction']), array('ASC','DESC')))
			{
				$access = false;
			}
		}
		if(isset($_GET['limit']))
		{
			if(!preg_match('/^\d+$/',$_GET['limit']))
			{
				$access = false;
			}
		}
		if($access == true)
		{
			$pjPropertyModel = pjPropertyModel::factory()
				->join('pjMultiLang', "t2.model='pjProperty' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left')
				->join('pjMultiLang', "t3.model='pjProperty' AND t3.foreign_id=t1.id AND t3.field='description' AND t3.locale='".$this->getLocaleId()."'", 'left')
				->join('pjMultiLang', "t4.model='pjType' AND t4.foreign_id=t1.type_id AND t4.field='name' AND t4.locale='".$this->getLocaleId()."'", 'left')
				->join('pjUser', "t5.id=t1.owner_id", 'left')
				->join('pjMultiLang', "t6.model='pjCountry' AND t6.foreign_id=t1.address_country AND t6.field='name' AND t6.locale='".$this->getLocaleId()."'", 'left');
			
			$column = '';
			switch ($_GET['sortby']) 
			{
				case 'added':
				 	$column = 'created';
					break;
				case 'updated':
					$column = 'modified';
					break;
				case 'expired':
					$column = 'expire';
					break;
				default:
					$column = 'created';
					break;
			}
			$direction = $_GET['direction'];
			$arr = $pjPropertyModel
				->select("	t1.id, t1.ref_id, t1.expire, t2.content as title, t3.content as description, t4.content as type, t5.name as owner_name, t1.created, t1.modified, t1.for, t1.bedrooms, t1.bathrooms, t1.year_built, 
							t1.price, t1.price_per, t1.floor_area, t6.content as country, t1.address_state, t1.address_city, t1.address_1, t1.address_zip")
				->orderBy("$column $direction")
				->limit($_GET['limit'])
				->findAll()
				->getData();
			foreach($arr as $k => $v)
			{
				if(!empty($v['expire']))
				{
					$v['expire'] = date($this->option_arr['o_date_format'], strtotime($v['expire']));
				}
				$v['created'] = date($this->option_arr['o_date_format'], strtotime($v['created'])) . ', ' . date($this->option_arr['o_time_format'], strtotime($v['created']));
				$v['modified'] = date($this->option_arr['o_date_format'], strtotime($v['modified'])) . ', ' . date($this->option_arr['o_time_format'], strtotime($v['modified']));
				$arr[$k] = $v;
			}
			$xml = new pjXML();
			echo $xml
				->setEncoding('UTF-8')
				->process($arr)
				->getData();
		}else{
			__('lblNoAccessToFeed');
		}
		
		exit;
	}
	
	public function pjActionResetContact()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$owner_id = null;
			if($this->isOwner())
			{
				$owner_id = $this->getUserId();
			}else if(isset($_GET['id']) && (int) $_GET['id'] > 0){
				$owner_id = $_GET['id'];
			}
			$arr = array();
			if($owner_id != null)
			{
				$arr = pjUserModel::factory()->find($owner_id)->getData();
			}
			pjAppController::jsonResponse($arr);
		}
		exit;
	}
	
	public function pjActionDeleteFile()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$response = array();
				
			$pjPropertyModel = pjPropertyModel::factory();
			$arr = $pjPropertyModel->find($_GET['id'])->getData();
				
			if(!empty($arr))
			{
				if(!empty($arr['floor_plan_filepath']))
				{
					@unlink(PJ_INSTALL_PATH . $arr['floor_plan_filepath']);
				}
	
				$data = array();
				$data['floor_plan_filepath'] = ':NULL';
				$data['floor_plan_filename'] = ':NULL';
				$data['floor_plan_mime'] = ':NULL';
				$data['floor_plan_hash'] = ':NULL';
				$pjPropertyModel->reset()->where(array('id' => $_GET['id']))->limit(1)->modifyAll($data);
	
				$response['code'] = 200;
			}else{
				$response['code'] = 100;
			}
				
			pjAppController::jsonResponse($response);
		}
	}
	
	public function pjActionSendNotification($id)
	{
		$arr = pjPropertyModel::factory()
			->join('pjMultiLang', "t2.model='pjType' AND t2.foreign_id=t1.type_id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t3.model='pjProperty' AND t3.foreign_id=t1.id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left')
			->join('pjUser', "t4.id=t1.owner_id", "left")
			->select('t1.*, t2.content as type, t3.content as title, t4.email, t4.phone')
			->find($id)
			->getData();
		if(!empty($arr))
		{
			$pjEmail = new pjEmail();
			if ($this->option_arr['o_send_email'] == 'smtp')
			{
				$pjEmail
				->setTransport('smtp')
				->setSmtpHost($this->option_arr['o_smtp_host'])
				->setSmtpPort($this->option_arr['o_smtp_port'])
				->setSmtpUser($this->option_arr['o_smtp_user'])
				->setSmtpPass($this->option_arr['o_smtp_pass'])
				->setSender($this->option_arr['o_smtp_user']);
			}
			$pjEmail->setContentType('text/html');
			$from = $this->getFromEmail($this->option_arr);
			$admin_email = $this->getAdminEmail();
			$to_email = !empty($arr['owner_email']) ? $arr['owner_email'] : (!empty($arr['email']) ? $arr['email'] : '');
			$to_phone = !empty($arr['owner_phone']) ? $arr['owner_phone'] : (!empty($arr['phone']) ? $arr['phone'] : '');
			$url = PJ_INSTALL_URL . 'index.php?controller=pjAdminProperties&action=pjActionUpdate&id=' . $arr['id'];
			$url = '<a href="'.$url.'">'.$url.'</a>';
			$search = array("{RefID}", "{Title}", "{Type}", "URL");
			$replace = array($arr['ref_id'], $arr['title'], $arr['type'], $url);

			
			$pjMultiLangModel = pjMultiLangModel::factory();
			if ($this->option_arr['o_email_submission'] == 1 && $to_email != '')
			{
				$lang_subject = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_email_submission_subject')
					->limit(0, 1)
					->findAll()->getData();
				$lang_message = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_email_submission_message')
					->limit(0, 1)
					->findAll()->getData();
					
				if (count($lang_message) === 1 && count($lang_subject) === 1)
				{
					$message = str_replace($search, $replace, $lang_message[0]['content']);
						
					$pjEmail
						->setTo($to_email)
						->setFrom($from)
						->setSubject($lang_subject[0]['content'])
						->send(pjUtil::textToHtml($message));
				}
			}
			if ($this->option_arr['o_admin_email_submission'] == 1)
			{
				$lang_subject = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_admin_email_submission_subject')
					->limit(0, 1)
					->findAll()->getData();
				$lang_message = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_admin_email_submission_message')
					->limit(0, 1)
					->findAll()->getData();
					
				if (count($lang_message) === 1 && count($lang_subject) === 1)
				{
					$message = str_replace($search, $replace, $lang_message[0]['content']);
					$pjEmail
						->setTo($admin_email)
						->setFrom($from)
						->setSubject($lang_subject[0]['content'])
						->send(pjUtil::textToHtml($message));
				}
			}
			if(!empty($to_phone) && $this->option_arr['o_sms_submission'] == 1)
			{
				$lang_message = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_sms_submission_message')
					->limit(0, 1)
					->findAll()->getData();
				if (count($lang_message) === 1)
				{
					$message = str_replace($search, $replace, $lang_message[0]['content']);
					$params = array(
							'text' => $message,
							'key' => md5($this->option_arr['private_key'] . PJ_SALT)
					);
					$params['number'] = $to_phone;
					$this->requestAction(array('controller' => 'pjSms', 'action' => 'pjActionSend', 'params' => $params), array('return'));
				}
			}
			$admin_phone = $this->getAdminPhone();
			if(!empty($admin_phone) && $this->option_arr['o_admin_sms_submission'] == 1)
			{
				$lang_message = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_admin_sms_submission_message')
					->limit(0, 1)
					->findAll()->getData();
				if (count($lang_message) === 1)
				{
					$message = str_replace($search, $replace, $lang_message[0]['content']);
					$params = array(
							'text' => $message,
							'key' => md5($this->option_arr['private_key'] . PJ_SALT)
					);
					$params['number'] = $admin_phone;
					$this->requestAction(array('controller' => 'pjSms', 'action' => 'pjActionSend', 'params' => $params), array('return'));
				}
			}
		}
	}
	
	public function pjActionGetPaymentForm()
	{
	    $this->setAjax(true);
	    
	    if ($this->isXHR())
	    {
	        if (isset($_GET['period_id']) && (int) $_GET['period_id'] > 0)
	        {
	            $period_arr = pjPeriodModel::factory()->find($_GET['period_id'])->getData();
	            $this->set('params', array(
	                'name' => 'plPaypal',
	                'id' => 'plPaypal',
	                'business' => $this->option_arr['o_paypal_address'],
	                'client_id' => $this->option_arr['o_paypal_client_id'],
	                'client_secret' => $this->option_arr['o_paypal_client_secret'],
	                'item_name' => __('payment_period', true) .'(#'.$period_arr['id'].'): '. $period_arr['days'] .' '. __('o_days', true),
	                'custom' => $_GET['property_id'].'-'.$_GET['period_id'],
	                'amount' => number_format($period_arr['price'], 2, '.', ''),
	                'currency_code' => $this->option_arr['o_currency'],
	                'return' => PJ_INSTALL_URL . "index.php?controller=pjAdminProperties&action=pjActionIndex",
	                'failure_url' => $this->option_arr['o_paypal_cancel_url'],
	                'notify_url' => PJ_INSTALL_URL . "index.php?controller=pjListings&action=pjActionConfirmPayment",
	                'target' => '_self',
	                'charset' => 'utf-8'
	            ));
	        }
	    }
	}
}
?>
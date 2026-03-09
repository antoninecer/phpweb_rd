<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}

class pjListings extends pjFront
{
	private $isoDatePattern = '/\d{4}-\d{2}-\d{2}/';
	
	public function pjActionCheckEmail()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (!isset($_GET['email']) || empty($_GET['email']))
			{
				echo 'false';
				exit;
			}
			$pjUserModel = pjUserModel::factory()->where('t1.email', $_GET['email']);
			if (isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				$pjUserModel->where('t1.id !=', $_GET['id']);
			}
			echo $pjUserModel->findCount()->getData() == 0 ? 'true' : 'false';
		}
		exit;
	}
	
	public function pjActionIndex()
	{
		pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=".$_GET['controller']."&action=pjActionProperties");
	}
	
	public function pjActionProperties()
	{
		$result = $this->pjGetProperties($_GET, 'index');
	
		$meta_arr = pjMultiLangModel::factory()->getMultiLang(1, 'pjOption');
	
		if($_GET['controller'] == 'pjListings')
		{
			$this->set('meta_arr', array(
					'title' => isset($meta_arr[$this->getLocaleId()]['home_meta_title']) ? $meta_arr[$this->getLocaleId()]['home_meta_title'] : null,
					'keywords' => isset($meta_arr[$this->getLocaleId()]['home_meta_keywords']) ? $meta_arr[$this->getLocaleId()]['home_meta_keywords'] : null,
					'description' => isset($meta_arr[$this->getLocaleId()]['home_meta_description']) ? $meta_arr[$this->getLocaleId()]['home_meta_description'] : null
			));
		}
		if($_GET['controller'] == 'pjWebsite')
		{
			$this->set('meta_arr', array(
					'title' => __('ws_properties_meta_title', true),
					'keywords' => __('ws_properties_meta_keywords', true),
					'description' => __('ws_properties_meta_description', true),
			));
		}
		$this->set('arr', $result['arr']);
		$this->set('type_arr', $result['type_arr']);
		$this->set('feature_arr', $result['feature_arr']);
		$this->set('paginator', $result['paginator']);
	}
	
	
	public function pjActionFeatured()
	{
		$this->set('arr', $this->getFeaturedProperties(false));
	}
	
	public function pjActionMap()
	{
		$result = $this->pjGetProperties($_GET, 'map');
	
		$meta_arr = pjMultiLangModel::factory()->getMultiLang(1, 'pjOption');
		
		if($_GET['controller'] == 'pjListings')
		{
			$this->set('meta_arr', array(
				'title' => isset($meta_arr[$this->getLocaleId()]['map_meta_title']) ? $meta_arr[$this->getLocaleId()]['map_meta_title'] : null,
				'keywords' => isset($meta_arr[$this->getLocaleId()]['map_meta_keywords']) ? $meta_arr[$this->getLocaleId()]['map_meta_keywords'] : null,
				'description' => isset($meta_arr[$this->getLocaleId()]['map_meta_description']) ? $meta_arr[$this->getLocaleId()]['map_meta_description'] : null
			));
		}
		if($_GET['controller'] == 'pjWebsite')
		{
			$this->set('meta_arr', array(
					'title' => __('ws_map_meta_title', true),
					'keywords' => __('ws_map_meta_keywords', true),
					'description' => __('ws_map_meta_description', true),
			));
		}
		
		$this->set('arr', $result['arr']);
		$this->set('type_arr', $result['type_arr']);
		$this->set('feature_arr', $result['feature_arr']);
	}
	
	public function pjActionView()
	{
		if(isset($_GET['id']) && (int) $_GET['id'] > 0)
		{
			$result = $this->pjGetPropertyDetails($_GET['id']);
			if($result['status'] == '200')
			{
				$related_arr = $this->pjGetProperties($_GET, $result['arr']['for'], $_GET['id']);
				$this->set('arr', $result['arr']);
				$this->set('meta_arr', $result['meta_arr']);
				$this->set('gallery_arr', $result['gallery_arr']);
				$this->set('feature_arr', $result['feature_arr']);
				$this->set('related_arr', $related_arr['arr']);
				pjPropertyModel::factory()->where('id', $_GET['id'])->modifyAll(array('views' => $result['arr']['views'] + 1));
				$this->set('featured_arr', $this->getFeaturedProperties(true));
			}
			
			$dm = new pjDependencyManager(PJ_INSTALL_PATH, PJ_THIRD_PARTY_PATH);
			$dm->load(PJ_CONFIG_PATH . 'dependencies.php')->resolve();
			$this->appendCss('lytebox.css', PJ_INSTALL_URL . preg_replace('|^' . PJ_INSTALL_PATH . '|', '', $dm->getPath('lytebox')), true);
			
			$this->set('status', $result['status']);
		}else{
			$this->set('status', '100');
		}
	}
	
	public function pjActionAccount()
	{
		if(isset($_POST['register']))
		{
			if($this->option_arr['o_allow_add_property'] == 'No')
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjListings&action=pjActionIndex");
			}
			if (!isset($_POST['name']))
			{
				$err = 101;
			}
			if (!isset($_POST['email']))
			{
				$err = 102;
			}
			if (!isset($_POST['password']))
			{
				$err = 103;
			}
			if (!isset($_POST['reenter_password']))
			{
				$err = 104;
			}
			if (!isset($_POST['captcha']))
			{
				$err = 111;
			}
			if (isset($_POST['name']) && !pjValidation::pjActionNotEmpty($_POST['name']))
			{
				$err = 105;
			}
			if (isset($_POST['email']) && !pjValidation::pjActionNotEmpty($_POST['email']))
			{
				$err = 106;
			}
			if (isset($_POST['password']) && !pjValidation::pjActionNotEmpty($_POST['password']))
			{
				$err = 107;
			}
			if (isset($_POST['reenter_password']) && !pjValidation::pjActionNotEmpty($_POST['reenter_password']))
			{
				$err = 108;
			}
			if (isset($_POST['captcha']) && !pjValidation::pjActionNotEmpty($_POST['captcha']))
			{
				$err = 112;
			}
			if (isset($_POST['email']) && !pjValidation::pjActionEmail($_POST['email']))
			{
				$err = 109;
			}
			if (isset($_POST['password']) && isset($_POST['reenter_password']) && !pjValidation::pjActionEqualTo($_POST['reenter_password'], $_POST['password']))
			{
				$err = 110;
			}
			if (empty($_SESSION[$this->defaultCaptcha]) || empty($_POST['captcha']) || !pjCaptcha::validate($_POST['captcha'], $_SESSION[$this->defaultCaptcha]) )
			{
				$err = 113;
			}
			if (isset($_POST['email']) && pjValidation::pjActionEmail($_POST['email']))
			{
				$cnt_users = pjUserModel::factory()->where('t1.email', $_GET['email'])->findCount()->getData();
				if($cnt_users > 0)
				{
					$err = 114;
				}
			}
			if (!isset($err))
			{
				if (isset($_SESSION[$this->defaultCaptcha]))
				{
					$_SESSION[$this->defaultCaptcha] = NULL;
					unset($_SESSION[$this->defaultCaptcha]);
				}
				
				$data = array();
				$data['role_id'] = 3;
				$data['status'] = $this->option_arr['o_owner_is_active'] == 'Yes' ? 'T' : 'F';
				$data['is_active'] = 'T';
				$data['ip'] = pjUtil::getClientIp();
					
				$id = pjUserModel::factory()->setAttributes(array_merge($_POST, $data))->insert()->getInsertId();
				if ($id !== false && (int) $id > 0)
				{
					pjListings::pjActionRegistrationEmail($id);
					if ($this->option_arr['o_owner_is_active'] == 'Yes')
					{
						pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjListings&action=pjActionAccount&status=200");
					}else{
						pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjListings&action=pjActionAccount&status=201");
					}
				}
			}else{
				$this->set('err', $err);
			}
		}
		if($_GET['controller'] == 'pjListings')
		{
			$meta_arr = pjMultiLangModel::factory()->getMultiLang(1, 'pjOption');
			$this->set('meta_arr', array(
					'title' => isset($meta_arr[$this->getLocaleId()]['account_meta_title']) ? $meta_arr[$this->getLocaleId()]['account_meta_title'] : null,
					'keywords' => isset($meta_arr[$this->getLocaleId()]['account_meta_keywords']) ? $meta_arr[$this->getLocaleId()]['account_meta_keywords'] : null,
					'description' => isset($meta_arr[$this->getLocaleId()]['account_meta_description']) ? $meta_arr[$this->getLocaleId()]['account_meta_description'] : null
			));
		}
	}
	
	public function pjActionForgot()
	{
		if(isset($_POST['forgot']))
		{
			if (!isset($_POST['email']))
			{
				$err = 101;
			}
			if (isset($_POST['email']) && !pjValidation::pjActionNotEmpty($_POST['email']))
			{
				$err = 102;
			}
			if (isset($_POST['email']) && !pjValidation::pjActionEmail($_POST['email']))
			{
				$err = 103;
			}
			if (!isset($err))
			{
				$arr = pjUserModel::factory()
					->where('t1.email', $_POST['email'])
					->limit(1)
					->findAll()
					->getData();
				if(empty($arr))
				{
					$err = 104;
				}
				if (!isset($err))
				{
					pjListings::pjActionForgotEmail($arr[0]['id']);
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjListings&action=pjActionForgot&status=200");
				}else{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjListings&action=pjActionForgot&err=$err");
				}
			}else{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjListings&action=pjActionForgot&err=$err");
			}	
		}
	}
	
	public function pjActionLogout()
	{
		if ($this->pjCheckLogin())
		{
			unset($_SESSION[$this->defaultOwner]);
		}
		pjUtil::redirect($_SERVER['PHP_SELF'] . '?controller=pjListings&action=pjActionIndex' . (isset($_POST['iframe']) ? '&iframe' : NULL));
	}
	
	public function pjActionGetPopup()
	{
		$this->setAjax(true);
		
		$arr = pjPropertyModel::factory()
			->join('pjUser', 't2.id=t1.owner_id', 'left')
			->select('t1.*, t2.name, t2.email, t2.phone, t2.fax')
			->find($_GET['id'])
			->getData();
		
		$this->set('arr', $arr);
	}
	
	public function pjActionSend()
	{
		$this->setAjax(true);
	
		$json_arr = array();
		if(isset($_POST['send']))
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
			
			if($_POST['send'] == 'email')
			{
				$code = 200;
				if (!isset($_POST['send_to']))
				{
					$code = 101;
				}
				if (!isset($_POST['subject']))
				{
					$code = 102;
				}
				if (!isset($_POST['message']))
				{
					$code = 103;
				}
				if (!isset($_POST['captcha']))
				{
					$code = 104;
				}
				if (isset($_POST['send_to']) && !pjValidation::pjActionNotEmpty($_POST['send_to']))
				{
					$code = 105;
				}
				if (isset($_POST['subject']) && !pjValidation::pjActionNotEmpty($_POST['subject']))
				{
					$code = 106;
				}
				if (isset($_POST['message']) && !pjValidation::pjActionNotEmpty($_POST['message']))
				{
					$code = 107;
				}
				if (isset($_POST['captcha']) && !pjValidation::pjActionNotEmpty($_POST['captcha']))
				{
					$code = 107;
				}
				if (isset($_POST['send_to']) && !pjValidation::pjActionEmail($_POST['send_to']))
				{
					$code = 109;
				}
				if ($_SESSION[$this->defaultCaptcha]== "" || $_POST['captcha']== "" || strtoupper($_POST['captcha']) != $_SESSION[$this->defaultCaptcha])
				{
					$code = 110;
				}
				if($code == 200)
				{
					if (isset($_SESSION[$this->defaultCaptcha]))
					{
						$_SESSION[$this->defaultCaptcha] = NULL;
						unset($_SESSION[$this->defaultCaptcha]);
					}
					
					$to = $_POST['send_to'];
					$subject = stripslashes($_POST['subject']);
					$message = pjUtil::textToHtml(stripslashes($_POST['message']));
					$pjEmail
						->setFrom($from)
						->setTo($to)
						->setSubject($subject)
						->send($message);
				}
				$json_arr['code'] = $code;
			}else if($_POST['send'] == 'request'){
				$code = 200;
				if (!isset($_POST['name']))
				{
					$code = 101;
				}
				if (!isset($_POST['email']))
				{
					$code = 102;
				}
				if (!isset($_POST['message']))
				{
					$code = 103;
				}
				if (!isset($_POST['captcha']))
				{
					$code = 104;
				}
				if (isset($_POST['name']) && !pjValidation::pjActionNotEmpty($_POST['name']))
				{
					$code = 105;
				}
				if (isset($_POST['email']) && !pjValidation::pjActionNotEmpty($_POST['email']))
				{
					$code = 106;
				}
				if (isset($_POST['message']) && !pjValidation::pjActionNotEmpty($_POST['message']))
				{
					$code = 107;
				}
				if (isset($_POST['captcha']) && !pjValidation::pjActionNotEmpty($_POST['captcha']))
				{
					$code = 107;
				}
				if (isset($_POST['email']) && !pjValidation::pjActionEmail($_POST['email']))
				{
					$code = 109;
				}
				if ($_SESSION[$this->defaultCaptcha]== "" || $_POST['captcha']== "" || !pjCaptcha::validate($_POST['captcha'], $_SESSION[$this->defaultCaptcha]))
				{
					$code = 110;
				}
				if($code == 200)
				{
					if (isset($_SESSION[$this->defaultCaptcha]))
					{
						$_SESSION[$this->defaultCaptcha] = NULL;
						unset($_SESSION[$this->defaultCaptcha]);
					}
					
					pjListings::pjActionRequestEmail($_POST);
				}
				$json_arr['code'] = $code;
			}
		}else{
			$json_arr['code'] = '100';
		}	
		
		pjAppController::jsonResponse($json_arr);
		exit;
	}
	
	public function pjActionPrint()
	{
		$this->setLayout('pjActionPrint');
		
		if(isset($_GET['id']))
		{
			if(isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				$result = $this->pjGetPropertyDetails($_GET['id']);
				if($result['status'] == '200')
				{
					$this->set('arr', $result['arr']);
					$this->set('meta_arr', $result['meta_arr']);
					$this->set('gallery_arr', $result['gallery_arr']);
					$this->set('feature_arr', $result['feature_arr']);
					pjPropertyModel::factory()->where('id', $_GET['id'])->modifyAll(array('prints' => $result['arr']['prints'] + 1));
				}
				$this->set('status', $result['status']);
			}else{
				$this->set('status', '100');
			}
		}else{
			$this->set('status', 100);
		}
	}
	
	public function pjActionConfirmPayment()
	{
		$this->setAjax(true);
		
		if (pjObject::getPlugin('pjPaypal') === NULL)
		{
			$this->log('Paypal plugin not installed');
			pjAppController::jsonResponse(array('status' => 'ERR', 'text' => 'Paypal plugin not installed'));
		}
		
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);
		if ($post) {
		    $_REQUEST = array_merge($_REQUEST, $post);
		}
		list($property_id, $period_id) = explode('-', $_REQUEST['custom']);
		
		$pjPaymentModel = pjPaymentModel::factory();
		$pjPropertyModel = pjPropertyModel::factory();
		
		$property_arr = $pjPropertyModel->find($property_id)->getData();
		$payment_arr = $pjPaymentModel->where('t1.property_id', $property_id)->orderBy('t1.date_to DESC')->limit(1)->findAll()->getData();
		$period_arr = pjPeriodModel::factory()->find($period_id)->getData();
		$date_from = date("Y-m-d");
		if (count($payment_arr) === 1)
		{
			$date_from = $payment_arr[0]['date_to'];
		}
		
		$period = (int) $period_arr['days'];
		$price = (float) $period_arr['price'];
		list($year, $month, $day) = explode("-", $date_from);
		$date_to = date("Y-m-d", mktime(0, 0, 0, $month, $day + $period, $year));
		
		$params = array(
		    'request'		=> $_REQUEST,
		    'cancel_hash'	=> sha1($property_arr['id'].strtotime($property_arr['created']).PJ_SALT),
		    'txn_id' => @$payment_arr['txn_id'],
		    'paypal_address' => $this->option_arr['o_paypal_address'],
		    'deposit' => $price,
		    'currency' => $this->option_arr['o_currency'],
		    'key' => md5($this->option_arr['private_key'] . PJ_SALT)
		);
		$response = $this->requestAction(array('controller' => 'pjPaypal', 'action' => 'pjActionConfirm', 'params' => $params), array('return'));
		if ($response !== FALSE && isset($response['status']) && $response['status'] === 'OK')
		{
			$this->log('pjPaypal > pjActionConfirm > status == OK');
			$pjPaymentModel
				->reset()
				->setAttributes(array(
					'property_id' => $property_arr['id'],
					'date_from' => $date_from,
					'date_to' => $date_to,
					'txn_id' => $response['transaction_id'],
					'price' => $price
				))
				->insert();
			$current = time();
			if (!empty($property_arr['expire']) && $property_arr['expire'] != '0000-00-00')
			{
				$current = strtotime($property_arr['expire']);
			}
			pjPropertyModel::factory()
				->set('id', $property_arr['id'])
				->modify(array(
					'last_extend' => 'paid',
					'status' => 'E',
					'expire' => date("Y-m-d", $current + $period * 86400)
				));
			$this->log('Payment confirmed');
			pjAppController::jsonResponse(array('status' => 'OK', 'text' => 'Payment confirmed'));
		} elseif (!$response) {
			$this->log('Authorization failed');
			pjAppController::jsonResponse(array('status' => 'ERR', 'text' => 'Authorization failed'));
		} else {
			$this->log('Payment not confirmed');
			pjAppController::jsonResponse(array('status' => 'ERR', 'text' => 'Payment not confirmed'));
		}
	}

	public function pjActionRequestEmail($post)
	{
		$pjPropertyModel = pjPropertyModel::factory();
		$arr = $pjPropertyModel
			->join("pjUser", "t2.id=t1.owner_id", "left")
			->select('t1.*, t2.name, t2.email, t2.phone, t2.fax')
			->find($post['id'])
			->getData();
		$from = $this->getFromEmail($this->option_arr);
		$admin_email = $this->getAdminEmail();
		
		$search = array("{RefID}", "{Name}", "{Email}", "{Phone}", "{Message}");
		$replace = array($arr['ref_id'], !empty($post['name']) ? $post['name'] : null, !empty($post['email']) ? $post['email'] : null, !empty($post['phone']) ? $post['phone'] : null, $post['message']);
		
		$owner_email = !empty($arr['owner_email']) ? $arr['owner_email'] : $arr['email'];
		$owner_phone = !empty($arr['owner_phone']) ? $arr['owner_phone'] : $arr['phone'];
				
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
		
		$pjMultiLangModel = pjMultiLangModel::factory();
		if ($this->option_arr['o_email_request'] == 1 && !empty($owner_email))
		{
			$lang_subject = $pjMultiLangModel
				->reset()
				->select('t1.*')
				->where('t1.model','pjOption')
				->where('t1.locale', $this->getLocaleId())
				->where('t1.field', 'o_email_request_subject')
				->limit(0, 1)
				->findAll()->getData();
			$lang_message = $pjMultiLangModel
				->reset()
				->select('t1.*')
				->where('t1.model','pjOption')
				->where('t1.locale', $this->getLocaleId())
				->where('t1.field', 'o_email_request_message')
				->limit(0, 1)
				->findAll()->getData();
				
			if (count($lang_message) === 1 && count($lang_subject) === 1)
			{
				$message = str_replace($search, $replace, $lang_message[0]['content']);
				
				$pjEmail
					->setTo($owner_email)
					->setFrom($from)
					->setSubject($lang_subject[0]['content'])
					->send(pjUtil::textToHtml($message));
				
				$pjPropertyModel->reset()->where('id', $arr['id'])->modifyAll(array('sents' => $arr['sents'] + 1));
			}
		}
		if(!empty($owner_phone) && $this->option_arr['o_sms_request'] == 1)
		{
			$lang_message = $pjMultiLangModel
				->reset()
				->select('t1.*')
				->where('t1.model','pjOption')
				->where('t1.locale', $this->getLocaleId())
				->where('t1.field', 'o_sms_request_message')
				->limit(0, 1)
				->findAll()->getData();
			if (count($lang_message) === 1)
			{
				$message = str_replace($search, $replace, $lang_message[0]['content']);
				$params = array(
					'text' => $message,
					'key' => md5($this->option_arr['private_key'] . PJ_SALT),
					'number' => $owner_phone
				);
				$this->requestAction(array('controller' => 'pjSms', 'action' => 'pjActionSend', 'params' => $params), array('return'));
			}
		}
		if ($this->option_arr['o_admin_email_request'] == 1)
		{
			$lang_subject = $pjMultiLangModel
				->reset()
				->select('t1.*')
				->where('t1.model','pjOption')
				->where('t1.locale', $this->getLocaleId())
				->where('t1.field', 'o_admin_email_request_subject')
				->limit(0, 1)
				->findAll()->getData();
			$lang_message = $pjMultiLangModel
				->reset()
				->select('t1.*')
				->where('t1.model','pjOption')
				->where('t1.locale', $this->getLocaleId())
				->where('t1.field', 'o_admin_email_request_message')
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
	}
	
	public function pjActionRegistrationEmail($id)
	{
		$arr = pjUserModel::factory()->find($id)->getData();
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
			$search = array("{Name}", "{Email}", "{Password}", "{Phone}");
			$replace = array($arr['name'], $arr['email'], $arr['password'], $arr['phone']);
			
			$pjMultiLangModel = pjMultiLangModel::factory();
			if ($this->option_arr['o_email_registration'] == 1 && $arr['email'] != '')
			{
				$lang_subject = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_email_registration_subject')
					->limit(0, 1)
					->findAll()->getData();
				$lang_message = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_email_registration_message')
					->limit(0, 1)
					->findAll()->getData();
					
				if (count($lang_message) === 1 && count($lang_subject) === 1)
				{
					$message = str_replace($search, $replace, $lang_message[0]['content']);
			
					$pjEmail
						->setTo($arr['email'])
						->setFrom($from)
						->setSubject($lang_subject[0]['content'])
						->send(pjUtil::textToHtml($message));
				}
			}
			if ($this->option_arr['o_admin_email_registration'] == 1)
			{
				$lang_subject = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_admin_email_registration_subject')
					->limit(0, 1)
					->findAll()->getData();
				$lang_message = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_admin_email_registration_message')
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
			if(!empty($arr['phone']) && $this->option_arr['o_sms_registration'] == 1)
			{
				$lang_message = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_sms_registration_message')
					->limit(0, 1)
					->findAll()->getData();
				if (count($lang_message) === 1)
				{
					$message = str_replace($search, $replace, $lang_message[0]['content']);
					$params = array(
							'text' => $message,
							'key' => md5($this->option_arr['private_key'] . PJ_SALT)
					);
					$params['number'] = $arr['phone'];
					$this->requestAction(array('controller' => 'pjSms', 'action' => 'pjActionSend', 'params' => $params), array('return'));
				}
			}
			$admin_phone = $this->getAdminPhone();
			if(!empty($admin_phone) && $this->option_arr['o_admin_sms_registration'] == 1)
			{
				$lang_message = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_sms_registration_message')
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
	
	public function pjActionForgotEmail($id)
	{
		$arr = pjUserModel::factory()->find($id)->getData();
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
			$search = array("{Name}", "{Password}");
			$replace = array($arr['name'], $arr['password']);
				
			if ($arr['email'] != '')
			{
				$pjMultiLangModel = pjMultiLangModel::factory();
				$lang_subject = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_email_forgot_subject')
					->limit(0, 1)
					->findAll()->getData();
				$lang_message = $pjMultiLangModel
					->reset()
					->select('t1.*')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_email_forgot_message')
					->limit(0, 1)
					->findAll()->getData();
					
				if (count($lang_message) === 1 && count($lang_subject) === 1)
				{
					$message = str_replace($search, $replace, $lang_message[0]['content']);
					$pjEmail
						->setTo($arr['email'])
						->setFrom($from)
						->setSubject($lang_subject[0]['content'])
						->send(pjUtil::textToHtml($message));
				}
			}
		}
	}
	
	public function pjGetPropertyDetails($id)
	{
		$pjPropertyModel = pjPropertyModel::factory();
		$arr = $pjPropertyModel
			->join('pjMultiLang', "t2.model='pjType' AND t2.foreign_id=t1.type_id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t3.model='pjProperty' AND t3.foreign_id=t1.id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t4.model='pjProperty' AND t4.foreign_id=t1.id AND t4.field='description' AND t4.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t5.model='pjCountry' AND t5.foreign_id=t1.address_country AND t5.field='name' AND t5.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t6.model='pjProperty' AND t6.foreign_id=t1.id AND t6.field='meta_title' AND t6.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t7.model='pjProperty' AND t7.foreign_id=t1.id AND t7.field='meta_keywords' AND t7.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t8.model='pjProperty' AND t8.foreign_id=t1.id AND t8.field='meta_description' AND t8.locale='".$this->getLocaleId()."'", 'left')
			->join('pjUser', 't9.id=t1.owner_id', 'left')
			->join('pjMultiLang', "t10.model='pjProperty' AND t10.foreign_id=t1.id AND t10.field='address_1' AND t10.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t11.model='pjProperty' AND t11.foreign_id=t1.id AND t11.field='address_city' AND t11.locale='".$this->getLocaleId()."'", 'left')
			->select('t1.*, t2.content as type, t3.content as title, t4.content as description, t5.content as country_title, t10.content as address_1, t11.content as address_city,
						 t6.content AS meta_title, t7.content AS meta_keywords, t8.content AS meta_description, t9.name, t9.email, t9.phone, t9.fax')
			->find($id)
			->getData();
			
		if(!empty($arr))
		{
			$status = '200';
			if($arr['status'] == 'F')
			{
				$status = '101';
			}
			if($arr['status'] == 'E')
			{
				if($arr['expire'] < date('Y-m-d'))
				{
					$status = '102';
				}
			}
			if($status == '200')
			{
				$gallery_arr = pjGalleryModel::factory()->where('t1.foreign_id', $id)->orderBy('t1.sort ASC')->findAll()->getData();
					
				$feature_arr = array();
				$_feature_arr = pjPropertyFeatureModel::factory()
					->join('pjMultiLang', "t2.model='pjFeature' AND t2.foreign_id=t1.feature_id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
					->join('pjFeature', "t3.id=t1.feature_id")
					->select('t1.*, t2.content as feature, t3.category_id')
					->where('t1.property_id', $id)
					->findAll()
					->getData();
				foreach($_feature_arr as $v)
				{
					$feature_arr[$v['category_id']][] = $v['feature'];
				}
				
				$meta_arr = array(
						'title' => $arr['meta_title'],
						'keywords' => $arr['meta_keywords'],
						'description' => $arr['meta_description']
				);
				return compact('status', 'arr', 'meta_arr', 'gallery_arr', 'feature_arr');
			}
			return compact('status');
		}else{
			return array('status'=>'103');
		}
	}
	
	public function pjGetProperties($get, $type, $id=null)
	{
		$feature_arr = pjFeatureModel::factory()
			->select('t1.*, t2.content AS name')
			->join('pjMultiLang', "t2.model='pjFeature' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
			->where('status', 'T')
			->findAll()->getData();
		
		$type_arr = pjTypeModel::factory()
			->join('pjMultiLang', "t2.foreign_id = t1.id AND t2.model = 'pjType' AND t2.locale = '".$this->getLocaleId()."' AND t2.field = 'name'", 'left')
			->select('t1.*, t2.content as name')
			->where('t1.status', 'T')
			->orderBy("name ASC")
			->findAll()
			->getData();
		
		$pjPropertyModel = pjPropertyModel::factory()
			->join('pjUser', 't2.id=t1.owner_id', 'left outer')
			->join('pjMultiLang', "t3.model='pjProperty' AND t3.foreign_id=t1.id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t4.model='pjProperty' AND t4.foreign_id=t1.id AND t4.field='description' AND t4.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t5.model='pjType' AND t5.foreign_id=t1.type_id AND t5.field='name' AND t5.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t6.model='pjCountry' AND t6.foreign_id=t1.address_country AND t6.field='name' AND t6.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t7.model='pjProperty' AND t7.foreign_id=t1.id AND t7.field='address_1' AND t7.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t8.model='pjProperty' AND t8.foreign_id=t1.id AND t8.field='address_city' AND t8.locale='".$this->getLocaleId()."'", 'left');
			
		$pjPropertyModel->where("(t1.status = 'T' OR (t1.status = 'E' AND t1.expire >= CURDATE()))");
		$pjPropertyModel->where("(t1.type_id IN (SELECT TT.id FROM `".pjTypeModel::factory()->getTable()."` AS `TT` WHERE `TT`.status='T'))");
		$pjPropertyModel->where("(t1.created <> t1.modified)");
		
		if(isset($get['listing_search']))
		{
			if (isset($get['for']) && !empty($get['for']))
			{
				$pjPropertyModel->where('t1.for', $get['for']);
			}
			if (isset($get['keyword']) && !empty($get['keyword']))
			{
				$keyword = pjObject::escapeString($get['keyword']);
				$pjPropertyModel->where("(t3.content LIKE '%$keyword%' OR t4.content LIKE '%$keyword%')");
			}
			if (isset($get['location']) && !empty($get['location']))
			{
				$location = pjObject::escapeString($get['location']);
				$pjPropertyModel->where("(t5.content LIKE '%$location%' OR t1.address_state LIKE '%$location%' OR t8.content LIKE '%$location%' OR t7.content LIKE '%$location%' OR t1.address_zip LIKE '%$location%' OR t6.content LIKE '%$location%')");
			}
			if (isset($get['type_id']) && (int) $get['type_id'])
			{
				$pjPropertyModel->where('t1.type_id', $get['type_id']);
			}
			if (isset($get['feature_id']) && (int) $get['feature_id'])
			{
				$pjPropertyModel->where("(t1.id IN(SELECT `TPF`.`property_id` FROM `".pjPropertyFeatureModel::factory()->getTable()."` AS `TPF` WHERE `TPF`.feature_id='".$get['feature_id']."'))");
			}
			if (isset($get['specials']) && !empty($get['specials']))
			{
				$pjPropertyModel->where('t1.special', $get['specials']);
			}
			if (isset($get['bedrooms']) && !empty($get['bedrooms']))
			{
				$pjPropertyModel->where('t1.bedrooms', $get['bedrooms']);
			}
			if (isset($get['bathrooms']) && !empty($get['bathrooms']))
			{
				$pjPropertyModel->where('t1.bathrooms', $get['bathrooms']);
			}
			$bedrooms_both = false;
			if (isset($get['min_bedrooms']))
			{
				if((int) $get['min_bedrooms'] > 0 )
				{
					if (isset($get['max_bedrooms'])){
						if((int)  $get['max_bedrooms'] > 0 )
						{
							if($get['min_bedrooms'] == '10')
							{
								$pjPropertyModel->where("(t1.bedrooms = '". '>'. $get['min_bedrooms']."')");
							}else if( $get['max_bedrooms'] == '10'){
								$pjPropertyModel->where("(t1.bedrooms >= '". '>'. $get['min_bedrooms']."')");
							}else{
								$pjPropertyModel->where("(t1.bedrooms >= ".$get['min_bedrooms']." AND t1.bedrooms <= ".$get['max_bedrooms'].")");
							}
							$bedrooms_both = true;
						}else{
							if($get['min_bedrooms'] == '10')
							{
								$pjPropertyModel->where("(t1.bedrooms = '". '>'. $get['min_bedrooms']."')");
							}else{
								$pjPropertyModel->where("(t1.bedrooms >= ".$get['min_bedrooms'].")");
							}
						}
					}else{
						if($get['min_bedrooms'] == '10')
						{
							$pjPropertyModel->where("(t1.bedrooms = '". '>'. $get['min_bedrooms']."')");
						}else{
							$pjPropertyModel->where("(t1.bedrooms >= ".$get['min_bedrooms'].")");
						}
					}
				}
			}
			if($bedrooms_both == false)
			{
				if (isset($get['max_bedrooms']))
				{
					if((int)  $get['max_bedrooms'] > 0)
					{
						if($get['max_bedrooms'] == '10')
						{
							$pjPropertyModel->where("(t1.bedrooms = '". '>'. $get['max_bedrooms']."')");
						}else{
							$pjPropertyModel->where("(t1.bedrooms <= ".$get['max_bedrooms'].")");
						}
					}
				}
			}
			$bathrooms_both = false;
			if (isset($get['min_bathrooms']))
			{
				if((int) $get['min_bathrooms'] > 0 )
				{
					if (isset($get['max_bathrooms']))
					{
						if((int) $get['max_bathrooms'] > 0)
						{
							if($get['min_bedrooms'] == '6')
							{
								$pjPropertyModel->where("(t1.bathrooms = '>5')");
							}else if($get['max_bathrooms'] == '6'){
								$pjPropertyModel->where("(t1.bathrooms >= '>5')");
							}else{
								$pjPropertyModel->where("(t1.bathrooms >= ".$get['min_bathrooms']." AND t1.bathrooms <= ".$get['max_bathrooms'].")");
							}
							$bathrooms_both = true;
						}else{
							if($get['min_bathrooms'] == '6')
							{
								$pjPropertyModel->where("(t1.bathrooms = '>5')");
							}else{
								$pjPropertyModel->where("(t1.bathrooms >= ".$get['min_bathrooms'].")");
							}
						}
					}else{
						if($get['min_bathrooms'] == '6')
						{
							$pjPropertyModel->where("(t1.bathrooms = '>5')");
						}else{
							$pjPropertyModel->where("(t1.bathrooms >= ".$get['min_bathrooms'].")");
						}
					}
				}
			}
			if($bathrooms_both == false)
			{
				if (isset($get['max_bathrooms']))
				{
					if((int)  $get['max_bathrooms'] > 0)
					{
						if($get['max_bathrooms'] == '6')
						{
							$pjPropertyModel->where("(t1.bathrooms = '>5')");
						}else{
							$pjPropertyModel->where("(t1.bathrooms <= ".$get['max_bathrooms'].")");
						}
					}
				}
			}
			$floor_area_both = false;
			if (isset($get['min_floor_area']))
			{
				if((int) $get['min_floor_area'] > 0)
				{
					if (isset($get['max_floor_area'])){
						if((int) $get['max_floor_area'] > 0)
						{
							$pjPropertyModel->where("t1.floor_area >=", pjObject::escapeString($get['min_floor_area']));
							$pjPropertyModel->where("t1.floor_area <=", pjObject::escapeString($get['max_floor_area']));
							$floor_area_both = true;
						}else{
							$pjPropertyModel->where("t1.floor_area >=", pjObject::escapeString($get['min_floor_area']));
						}
					}else{
						$pjPropertyModel->where("t1.floor_area >=", pjObject::escapeString($get['min_floor_area']));
					}
				}
			}
			if($floor_area_both == false)
			{
				if (isset($get['max_floor_area']))
				{
					if((int) $get['max_floor_area'] > 0)
					{
						$pjPropertyModel->where("t1.floor_area <=", pjObject::escapeString($get['max_floor_area']));
					}
				}
			}
		}

		$column = 't1.created';
		$direction = 'DESC';
		if($type == 'index')
		{
			$total = $pjPropertyModel->findCount()->getData();
			$items_per_page = (int) $this->option_arr['o_items_per_page'] > 0 ? $this->option_arr['o_items_per_page'] : 10;
			$rowCount = isset($get['rowCount']) && (int) $get['rowCount'] > 0 ? (int) $get['rowCount'] : $items_per_page;
			$pages = ceil($total / $rowCount);
			$page = isset($get['pjPage']) && (int) $get['pjPage'] > 0 ? intval($get['pjPage']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}
			$sorting = 't1.is_featured ASC, t1.created DESC';
			$arr = $pjPropertyModel
				->select(sprintf("t1.*, t3.content AS title, t1.expire, t1.status, t4.content as description, t5.content as type, t6.content as country_title, t7.content as address_1, t8.content as address_city,
					(SELECT `small_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `image`,
					(SELECT `medium_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `medium_image`,
					(SELECT `large_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `large_image`", pjGalleryModel::factory()->getTable(), pjGalleryModel::factory()->getTable(), pjGalleryModel::factory()->getTable()))
				->orderBy($sorting)
				->limit($rowCount, $offset)
				->findAll()
				->getData();
			$paginator = array('pages' => $pages, 'total' => $total);
			return compact('type_arr', 'feature_arr', 'arr', 'paginator');
		}else if($type == 'map'){
			$pjPropertyModel->where('t1.show_googlemap', 'T');
			$arr = $pjPropertyModel
				->select(sprintf("t1.*, t3.content AS title, t1.expire, t1.status, t4.content as description, t5.content as type, t6.content as country_title, t7.content as address_1, t8.content as address_city,
					(SELECT `small_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `image`,
					(SELECT `medium_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `medium_image`,
					(SELECT `large_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `large_image`", pjGalleryModel::factory()->getTable(), pjGalleryModel::factory()->getTable(), pjGalleryModel::factory()->getTable()))
				->orderBy("$column $direction")
				->findAll()
				->getData();
			return compact('type_arr', 'feature_arr', 'arr');
		}else{
			$sorting = 't1.is_featured ASC, t1.created DESC';
			$pjPropertyModel->where('t1.for', $type);
			$pjPropertyModel->where('t1.id <>', $id);
			$arr = $pjPropertyModel
				->select(sprintf("t1.*, t3.content AS title, t1.expire, t1.status, t4.content as description, t5.content as type, t6.content as country_title, t7.content as address_1, t8.content as address_city,
					(SELECT `small_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `image`,
					(SELECT `medium_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `medium_image`,
					(SELECT `large_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `large_image`", pjGalleryModel::factory()->getTable(), pjGalleryModel::factory()->getTable(), pjGalleryModel::factory()->getTable()))
				->orderBy($sorting)
				->limit(PJ_SIMILAR_PROPERTIES)
				->findAll()
				->getData();
			return compact('type_arr', 'feature_arr', 'arr');
		}
	}
	
	public function getFeaturedProperties()
	{
		$pjPropertyModel = pjPropertyModel::factory()
			->join('pjUser', 't2.id=t1.owner_id', 'left outer')
			->join('pjMultiLang', "t3.model='pjProperty' AND t3.foreign_id=t1.id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t4.model='pjProperty' AND t4.foreign_id=t1.id AND t4.field='description' AND t4.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t5.model='pjType' AND t5.foreign_id=t1.type_id AND t5.field='name' AND t5.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t6.model='pjCountry' AND t6.foreign_id=t1.address_country AND t6.field='name' AND t6.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t7.model='pjProperty' AND t7.foreign_id=t1.id AND t7.field='address_1' AND t7.locale='".$this->getLocaleId()."'", 'left')
			->join('pjMultiLang', "t8.model='pjProperty' AND t8.foreign_id=t1.id AND t8.field='address_city' AND t8.locale='".$this->getLocaleId()."'", 'left')
			->select(sprintf("t1.*, t3.content AS title, t1.expire, t1.status, t4.content as description, t5.content as type, t6.content as country_title, t7.content as address_1, t8.content as address_city,
					(SELECT `large_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `image`,
					(SELECT `medium_path` FROM `%s` WHERE foreign_id = t1.id ORDER BY `sort` ASC LIMIT 1) AS `medium_image`", pjGalleryModel::factory()->getTable(), pjGalleryModel::factory()->getTable()));
		$pjPropertyModel->where("(t1.status = 'T' OR (t1.status = 'E' AND t1.expire >= CURDATE()))");
		$pjPropertyModel->where("t1.is_featured", 'T');
		$pjPropertyModel->where("(t1.type_id IN (SELECT TT.id FROM `".pjTypeModel::factory()->getTable()."` AS `TT` WHERE `TT`.status='T'))");
		
		$sorting = 't1.created DESC';
		$cnt = $pjPropertyModel->findCount()->getData();
		if($cnt > $this->option_arr['o_featured_items_per_page'])
		{
			$sorting = 'RAND()';
		}
		$pjPropertyModel->limit(6, 0);
		
		$arr = $pjPropertyModel
			->orderBy($sorting)
			->findAll()
			->getData();
		
		return $arr;
	}
}
?>
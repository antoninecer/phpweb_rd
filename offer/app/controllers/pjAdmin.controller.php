<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdmin extends pjAppController
{
	public $defaultUser = 'admin_user';
	
	public $requireLogin = true;
	
	public function __construct($requireLogin=null)
	{
		$this->setLayout('pjActionAdmin');
		
		if (!is_null($requireLogin) && is_bool($requireLogin))
		{
			$this->requireLogin = $requireLogin;
		}
		
		if ($this->requireLogin)
		{
			if (!$this->isLoged() && !in_array(@$_GET['action'], array('pjActionLogin', 'pjActionForgot', 'pjActionGetXMLFeed')))
			{
				if (!$this->isXHR())
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin");
				} else {
					pjAppController::jsonResponse(array('redirect' => PJ_INSTALL_URL . "index.php?controller=pjAdmin&action=pjActionLogin"));
				}
			}
		}
	}
	
	public function afterFilter()
	{
		parent::afterFilter();
		if ($this->isLoged() && !in_array(@$_GET['action'], array('pjActionLogin')))
		{
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
		}
	}
	
	public function beforeRender()
	{
		
	}
		
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if ($this->isAdmin() || $this->isEditor() || $this->isOwner())
		{
			$pjPropertyModel = pjPropertyModel::factory();
			
			$where_str = '';
			if($this->isOwner())
			{
				$where_str = " AND t1.owner_id='".$this->getUserId()."'";
			}
			
			$total_properties = $pjPropertyModel->where("(t1.status = 'T' OR (t1.status = 'E' AND t1.expire >= CURDATE()))$where_str")->findCount()->getData();
			$active_for_rent = $pjPropertyModel->reset()->where("(t1.status = 'T' OR (t1.status = 'E' AND t1.expire >= CURDATE()))$where_str")->where("t1.for", 'rent')->findCount()->getData();
			$active_for_sale = $pjPropertyModel->reset()->where("(t1.status = 'T' OR (t1.status = 'E' AND t1.expire >= CURDATE()))$where_str")->where("t1.for", 'sale')->findCount()->getData();
			
			$latest_added_arr = $pjPropertyModel->reset()
				->select(sprintf("t1.id, t1.ref_id, t1.created, t2.content AS type, t1.for,
					(SELECT `small_path` FROM `%s` WHERE `foreign_id` = `t1`.`id` ORDER BY `sort` ASC LIMIT 1) AS `pic`",
					pjGalleryModel::factory()->getTable()))
				->join('pjMultiLang', "t2.model='pjType' AND t2.foreign_id=t1.type_id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
				->where("(t1.id > 0$where_str)")
				->limit(3)
				->orderBy('t1.created DESC')
				->findAll()
				->getData();
			
			$latest_updated_arr = $pjPropertyModel->reset()
				->select(sprintf("t1.id, t1.ref_id, t1.created, t1.modified, t2.content AS type, t1.for,
					(SELECT `small_path` FROM `%s` WHERE `foreign_id` = `t1`.`id` ORDER BY `sort` ASC LIMIT 1) AS `pic`",
					pjGalleryModel::factory()->getTable()))
				->join('pjMultiLang', "t2.model='pjType' AND t2.foreign_id=t1.type_id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
				->where("(t1.id > 0$where_str)")
				->limit(3)
				->orderBy('t1.modified DESC')
				->findAll()
				->getData();
			
			$next_expiring_arr = $pjPropertyModel->reset()
				->select(sprintf("t1.id, t1.ref_id, t1.created, t1.expire, t2.content AS type, t1.for,
					(SELECT `small_path` FROM `%s` WHERE `foreign_id` = `t1`.`id` ORDER BY `sort` ASC LIMIT 1) AS `pic`",
					pjGalleryModel::factory()->getTable()))
				->join('pjMultiLang', "t2.model='pjType' AND t2.foreign_id=t1.type_id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left')
				->where("(t1.status = 'E' AND t1.expire >= CURDATE()$where_str)")
				->limit(3)
				->orderBy('t1.expire ASC')
				->findAll()
				->getData();
			
			$this->set('total_properties', $total_properties);
			$this->set('active_for_rent', $active_for_rent);
			$this->set('active_for_sale', $active_for_sale);
			
			$this->set('latest_added_arr', $latest_added_arr);
			$this->set('latest_updated_arr', $latest_updated_arr);
			$this->set('next_expiring_arr', $next_expiring_arr);
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionForgot()
	{
		$this->setLayout('pjActionAdminLogin');
		
		if (isset($_POST['forgot_user']))
		{
			if (!isset($_POST['forgot_email']) || !pjValidation::pjActionNotEmpty($_POST['forgot_email']) || !pjValidation::pjActionEmail($_POST['forgot_email']))
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=AA10");
			}
			$pjUserModel = pjUserModel::factory();
			$user = $pjUserModel
				->where('t1.email', $_POST['forgot_email'])
				->limit(1)
				->findAll()
				->getData();
				
			if (count($user) != 1)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=AA10");
			} else {
				$user = $user[0];
				$from = $this->getFromEmail($this->option_arr);
				$Email = new pjEmail();
				$Email
					->setTo($user['email'])
					->setFrom($from)
					->setSubject(__('emailForgotSubject', true));
				
				if ($this->option_arr['o_send_email'] == 'smtp')
				{
					$Email
						->setTransport('smtp')
						->setSmtpHost($this->option_arr['o_smtp_host'])
						->setSmtpPort($this->option_arr['o_smtp_port'])
						->setSmtpUser($this->option_arr['o_smtp_user'])
						->setSmtpPass($this->option_arr['o_smtp_pass'])
						->setSender($this->option_arr['o_smtp_user'])
					;
				}
				
				$body = str_replace(
					array('{Name}', '{Password}'),
					array($user['name'], $user['password']),
					__('emailForgotBody', true)
				);

				if ($Email->send($body))
				{
					$err = "AA11";
				} else {
					$err = "AA12";
				}
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=$err");
			}
		} else {
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdmin.js');
		}
	}
	
	public function pjActionMessages()
	{
		$this->setAjax(true);
		header("Content-Type: text/javascript; charset=utf-8");
	}
	
	public function pjActionLogin()
	{
		$this->setLayout('pjActionAdminLogin');
		
		if (isset($_POST['login_user']))
		{
			if (!isset($_POST['login_email']) || !isset($_POST['login_password']) ||
				!pjValidation::pjActionNotEmpty($_POST['login_email']) ||
				!pjValidation::pjActionNotEmpty($_POST['login_password']) ||
				!pjValidation::pjActionEmail($_POST['login_email']))
			{				
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=4");
			}
			$pjUserModel = pjUserModel::factory();

			$user = $pjUserModel
				->where('t1.email', $_POST['login_email'])
				->where(sprintf("t1.password = AES_ENCRYPT('%s', '%s')", pjObject::escapeString($_POST['login_password']), PJ_SALT))
				->limit(1)
				->findAll()
				->getData();

			if (count($user) != 1)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=1");
			} else {
				$user = $user[0];
				unset($user['password']);
															
				if (!in_array($user['role_id'], array(1,2,3)))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=2");
				}
				
				if ($user['role_id'] == 3 && $user['is_active'] == 'F')
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=2");
				}
				
				if ($user['status'] != 'T')
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=3");
				}
				
				$last_login = date("Y-m-d H:i:s");
    			$_SESSION[$this->defaultUser] = $user;
    			
    			$data = array();
    			$data['last_login'] = $last_login;
    			$pjUserModel->reset()->setAttributes(array('id' => $user['id']))->modify($data);

    			if ($this->isAdmin() || $this->isEditor() || $this->isOwner())
    			{
	    			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionIndex");
    			}
			}
		} else {
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdmin.js');
		}
	}
	
	public function pjActionLogout()
	{
		if ($this->isLoged())
        {
        	unset($_SESSION[$this->defaultUser]);
        }
       	pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin");
	}
	
	public function pjActionProfile()
	{
		$this->checkLogin();
		
		if (!$this->isAdmin())
		{
			if (isset($_POST['profile_update']))
			{
				$pjUserModel = pjUserModel::factory();
				$arr = $pjUserModel->find($this->getUserId())->getData();
				$data = array();
				$data['role_id'] = $arr['role_id'];
				$data['status'] = $arr['status'];
				$post = array_merge($_POST, $data);
				if (!$pjUserModel->validates($post))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionProfile&err=AA14");
				}
				$pjUserModel->set('id', $this->getUserId())->modify($post);
				
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionProfile&err=AA13");
			} else {
				$this->set('arr', pjUserModel::factory()->find($this->getUserId())->getData());
				$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
				$this->appendJs('pjAdmin.js');
			}
		} else {
			$this->set('status', 2);
		}
	}
}
?>
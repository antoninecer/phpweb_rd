<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjFront extends pjAppController
{	
	public $defaultCaptcha = 'pjPropertyListing_Captcha';
	
	public $defaultLocale = 'pjPropertyListing_LocaleId';
	
	public $defaultOwner = 'pjPropertyListing_Owner';
		
	public $defaultTheme = 'front_theme_id';
	
	public $defaultBackUrl = 'front_back_url';
	
	public function __construct()
	{
		$this->setLayout('pjActionFront');
	}

	public function afterFilter()
	{		
		$theme = $this->getTheme();
		if($theme == false)
		{
			$theme = $this->option_arr['o_theme'];
		}
		if(isset($_GET['pjBootstrapSite']) && $_GET['pjBootstrapSite'] === 1 )
		{
			$this->appendCss('style.css', PJ_TEMPLATE_PATH . PJ_TEMPLATE_SCRIPT_PATH . 'css/');
			$this->appendCss($theme . '.css', PJ_TEMPLATE_PATH . PJ_TEMPLATE_SCRIPT_PATH . 'css/');
		}else{
			$this->appendCss('pj.bootstrap.min.css', PJ_FRAMEWORK_LIBS_PATH. 'pj/css/');
			$this->appendCss('style.css', PJ_TEMPLATE_PATH . PJ_TEMPLATE_SCRIPT_PATH . 'css/');
			$this->appendCss($theme . '.css', PJ_TEMPLATE_PATH . PJ_TEMPLATE_SCRIPT_PATH . 'css/');
		}
	}
	
	public function beforeFilter()
	{
		$locale_arr = pjLocaleModel::factory()
			->select('t1.*, t2.file, t2.title')
			->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
			->where('t2.file IS NOT NULL')
			->orderBy('t1.sort ASC')
			->findAll()
			->getData();
			
		$this->set('locale_arr', $locale_arr);
		
		$OptionModel = pjOptionModel::factory();
		$this->option_arr = $OptionModel->getPairs($this->getForeignId());
		$this->set('option_arr', $this->option_arr);
		$this->setTime();

		if (!isset($_SESSION[$this->defaultLocale]))
		{
			$locale_arr = pjLocaleModel::factory()->where('is_default', 1)->limit(1)->findAll()->getData();
			if (count($locale_arr) === 1)
			{
				$this->setLocaleId($locale_arr[0]['id']);
			}
		}
		if(isset($_GET['theme']))
		{
			$this->setTheme($_GET['theme']);
		}
		
		$this->loadSetFields();
	}
	
	public function beforeRender()
	{
		if (isset($_GET['iframe']))
		{
			$this->setLayout('pjActionIframe');
		}
	}
	
	public function pjActionLocale()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (isset($_GET['locale_id']))
			{
				$this->pjActionSetLocale($_GET['locale_id']);
				
				$this->loadSetFields(true);
				
				$day_names = __('day_names', true);
				ksort($day_names, SORT_NUMERIC);
				
				$months = __('months', true);
				ksort($months, SORT_NUMERIC);
				
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Locale have been changed.', 'opts' => array(
					'day_names' => array_values($day_names),
					'month_names' => array_values($months)
				)));
			}
		}
		exit;
	}
	
	public function pjActionGetLocale()
	{
		return isset($_SESSION[$this->defaultLocale]) && (int) $_SESSION[$this->defaultLocale] > 0 ? (int) $_SESSION[$this->defaultLocale] : FALSE;
	}
	
	public function pjCheckLogin()
	{
		if (isset($_SESSION[$this->defaultOwner]) && count($_SESSION[$this->defaultOwner]) > 0)
		{
			return true;
		}
		return false;
	}
	
	public function pjActionCaptcha()
	{
		$this->setAjax(true);
		$Captcha = new pjCaptcha('app/web/obj/Anorexia.ttf', $this->defaultCaptcha, 6);
		$Captcha->setImage('app/web/img/button.png')->init(isset($_GET['rand']) ? $_GET['rand'] : null);
	}

	public function pjActionCheckCaptcha()
	{
		$this->setAjax(true);
		if (!isset($_GET['captcha']) || empty($_GET['captcha']) || !pjCaptcha::validate($_GET['captcha'], $_SESSION[$this->defaultCaptcha])){
			echo 'false';
		}else{
			echo 'true';
		}
	}
	
	public function pjActionDownloadFile()
	{
		$id = $_GET['id'];
		$arr = pjPropertyModel::factory()->find($id)->getData();
		if(!empty($arr))
		{
			if($arr['floor_plan_hash'] == $_GET['hash'])
			{
				pjToolkit::download(@file_get_contents(PJ_INSTALL_PATH . $arr['floor_plan_filepath']), $arr['floor_plan_filename'], $arr['floor_plan_mime']);
			}else{
				__('front_file_not_found');
			}
		}else{
			__('front_file_not_found');
		}
		exit;
	}
	
	public function pjActionSetLocale()
	{
		$this->setLocaleId(@$_GET['locale']);
		$this->loadSetFields(true);
		pjUtil::redirect($_SERVER['HTTP_REFERER']);
	}
}
?>
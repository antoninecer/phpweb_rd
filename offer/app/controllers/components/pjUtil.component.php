<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjUtil extends pjToolkit
{
	static public function getReferer()
	{
		if (isset($_GET['_escaped_fragment_']))
		{
			if (isset($_SERVER['REDIRECT_URL']))
			{
				return $_SERVER['REDIRECT_URL'];
			}
		}
		
		if (isset($_SERVER['HTTP_REFERER']))
		{
			$pos = strpos($_SERVER['HTTP_REFERER'], "#");
			if ($pos !== FALSE)
			{
				return substr($_SERVER['HTTP_REFERER'], 0, $pos);
			}
			return $_SERVER['HTTP_REFERER'];
		}
	}
	
	static public function getPageURL()
	{
		$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
		if ($_SERVER["SERVER_PORT"] != "80")
		{
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else
		{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	static public function getClientIp()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		} else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
			return $_SERVER['HTTP_X_FORWARDED'];
		} else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_FORWARDED_FOR'];
		} else if(isset($_SERVER['HTTP_FORWARDED'])) {
			return $_SERVER['HTTP_FORWARDED'];
		} else if(isset($_SERVER['REMOTE_ADDR'])) {
			return $_SERVER['REMOTE_ADDR'];
		}

		return 'UNKNOWN';
	}
	
	static public function textToHtml($content)
	{
		$content = preg_replace('/\r\n|\n/', '<br />', $content);
		return '<html><head><title></title></head><body>'.$content.'</body></html>';
	}
	static public function html2txt($document)
	{
		$search = array('@<script[^>]*?>.*?</script>@si',
				'@<[\/\!]*?[^<>]*?>@si',
				'@<style[^>]*?>.*?</style>@siU',
				'@<![\s\S]*?--[ \t\n\r]*>@'
		);
		$text = preg_replace($search, '', $document);
		return $text;
	}
	static public function getUuid()
	{
		return chr(rand(65,90)) . chr(rand(65,90)) . time();
	}
	static public function sortArrayByArray(Array $array, Array $orderArray) 
	{
		$ordered = array();
		foreach($orderArray as $key) {
			if(array_key_exists($key,$array)) {
				$ordered[$key] = $array[$key];
				unset($array[$key]);
			}
		}
		return $ordered + $array;
	}
	static public function truncateDescription($string, $limit, $break=".", $pad="..."){
		if(strlen($string) <= $limit)
			return $string;
		if(false !== ($breakpoint = strpos($string, $break, $limit)))
		{
			if($breakpoint < strlen($string) - 1)
			{
				$string = substr($string, 0, $breakpoint) . $pad;
			}
		}
		return $string;
	}
	static public function formatPrice($price, $format, $currency_code)
	{
		$price = preg_replace('/\s+/', '', $price);
		$price = str_replace(',', '', $price);
	
		switch($format)
		{
			case "$100000":
				$price = number_format($price, 0, '.', '');
				break;
			case "$100 000":
				$price = number_format($price, 0, '.', ' ');
				break;
			case "$100,000":
				$price = number_format($price, 0, '.', ',');
				break;
			case "$100,000.00":
				$price = number_format($price, 2, '.', ',');
				break;
		}
		$price = pjUtil::getCurrencySign($currency_code, false) . $price;
	
		return $price;
	}
	static public function getFileNames($dir)
	{
		$files = array();
		$dh = opendir($dir);
		while (false !== ($filename = readdir($dh))) 
		{
			if($filename != '.' && $filename != '..')
			{
				$files[] = $filename;
			}
		}
		rsort($files);
		return $files;
	}
}
?>
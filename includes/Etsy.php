<?php
class Etsy {

	public $endpoint = null;
	public $params = null;
	public $result = null;

	private $request_url = null;
	private $response = null;
	private $api_rate_limit = null;
	private $api_rate_remaining = null;

	function __construct()
	{

	}

	function queryEtsy()
	{
		if (!empty($this->endpoint))
		{
			$ch = curl_init();

			$this->request_url = 'https://openapi.etsy.com/v2' . $this->endpoint . '?api_key=' . ETSY_KEYSTRING . ((!empty($this->params)) ? '&' . http_build_query($this->params) : '');

			$cache_file = md5($this->request_url);

			$cached_result = self::cache_exists($cache_file, ETSY_CACHE_TIMEOUT); // cache within timeout

			if ($cached_result)
			{
				$this->result = json_decode($cached_result);
			}
			else
			{
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLOPT_VERBOSE, 0);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
				//		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
				//		curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'SSLv3');
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_TIMEOUT, 15);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
				curl_setopt($ch, CURLOPT_URL, $this->request_url);

				$this->response = curl_exec($ch);

				$err     = curl_errno($ch);
				$errmsg  = curl_error($ch);
			}

			if ($this->response)
			{
				$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$header = trim(substr($this->response, 0, $header_size));
				$json = substr($this->response, $header_size);

				$this->result = json_decode($json);

				if (!empty($this->result->count))
				{
					self::cache_write($json, $cache_file);
				}

				$headers = self::parseHeaders(explode("\r\n", $header));

				$this->api_rate_limit = $headers['x-ratelimit-limit'];
				$this->api_rate_remaining = $headers['x-ratelimit-remaining'];
			}

			curl_close($ch);
		}

		return false;
	}

	function parseHeaders(array $headers, $header = null)
	{
		$output = array();

		if ('HTTP' === substr($headers[0], 0, 4))
		{
			list(, $output['status'], $output['status_text']) = explode(' ', $headers[0]);
			unset($headers[0]);
		}

		foreach ($headers as $v)
		{
			$h = preg_split('/:\s*/', $v);
			$output[strtolower($h[0])] = $h[1];
		}

		if (null !== $header)
		{
			if (isset($output[strtolower($header)])) {
				return $output[strtolower($header)];
			}

			return;
		}

		return $output;
	}

	function cache_exists($file, $seconds = 60)
	{
		$file = CURL_CACHE . '/' . $file;

		if(file_exists($file) && filemtime($file) > (TIMENOW - $seconds))
		{
			return @file_get_contents($file);
		}
		else
		{
			return false;
		}
	}

	function cache_write($string, $file, $write = 'w+')
	{
		$file = CURL_CACHE . '/' . $file;

		$dirname = dirname($file);
		if (!is_dir($dirname))
		{
			@mkdir($dirname, 0777, true);
		}

		$tsf = @fopen($file, $write);
		@fwrite($tsf, $string);
		@fclose($tsf);

		return $string;
	}
}
?>
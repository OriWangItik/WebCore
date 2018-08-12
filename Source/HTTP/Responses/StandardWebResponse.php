<?php
namespace WebCore\HTTP\Responses;


use WebCore\Cookie;
use WebCore\IWebResponse;


class StandardWebResponse implements IWebResponse
{
	private $headers 	= [];
	
	/** @var Cookie[] */
	private $cookies 	= [];
	
	private $body 		= '';
	
	/** @var callable|null */
	private $callback 	= null;
	
	
	public function getHeaders(): array
	{
		return $this->headers;
	}
	
	public function setHeaders(array $headers): void
	{
		$this->headers = $headers;
	}
	
	public function addHeaders(array $headers): void
	{
		$this->headers = array_merge($this->headers, $headers);
	}
	
	public function setHeader(string $header, string $value): void
	{
		$this->headers[$header] = $value;
	}
	
	public function hasHeader(string $header): bool
	{
		return isset($this->headers[$header]);
	}
	
	public function getCookies(): array
	{
		return $this->cookies;
	}
	
	public function setCookies(array $cookies): void
	{
		$this->cookies = $cookies;
	}
	
	public function addCookies(array $cookies): void
	{
		$this->cookies = array_merge($this->cookies, $cookies);
	}
	
	public function setCookieByName(string $cookie, string $value): void
	{
		$this->cookies[$cookie] = Cookie::create($cookie, (string)$value);
	}
	
	public function setCookie(Cookie $cookie): void
	{
		$this->cookies[$cookie->Name] = $cookie;
	}
	
	/**
	 * @param string $name
	 * @param null|string $value
	 * @param int|string $expire
	 * @param null|string $path
	 * @param null|string $domain
	 * @param bool $secure
	 * @param bool $serverOnly
	 */
	public function createCookie(
		string $name,
		?string $value = null,
		$expire = 0,
		?string $path = null,
		?string $domain = null,
		bool $secure = false,
		bool $serverOnly = false): void
	{
		$this->setCookie(Cookie::create($name, $value, $expire, $path, $domain, $secure, $serverOnly));
	}
	
	public function hasCookie(string $cookie): bool
	{
		return isset($this->cookies[$cookie]);
	}
	
	public function getBody(): string
	{
		if ($this->callback)
		{
			$callback = $this->callback;
			return $callback();
		}
		
		return $this->body;
	}
	
	public function setBody(string $body): void
	{
		$this->body = $body;
	}
	
	public function setBodyCallback(callable $callback): void
	{
		$this->callback = $callback;
	}
	
	/**
	 * @param array|int|double|bool|string $body
	 */
	public function setJSON($body): void
	{
		$this->body = jsonencode($body);
	}
	
	public function apply(): void
	{
		foreach ($this->headers as $headerName => $headerValue)
		{
			header("$headerName: $headerValue");
		}
		
		foreach ($this->cookies as $cookie)
		{
			$cookie->apply();
		}
		
		echo $this->getBody();
	}
}
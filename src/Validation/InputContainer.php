<?php
namespace WebCore\Validation;


use Narrator\Narrator;
use WebCore\IInput;
use WebCore\IRequest;
use WebCore\IRequestInput;

use WebCore\Base\Input\IInputContainer;
use WebCore\RequestInput;


class InputContainer implements IInputContainer
{
	/** @var IRequestInput */
	private $requestInput;
	
	/** @var IInput|null */
	private $input;
	
	
	public function __construct(RequestInput $requestInput, IInput $input)
	{
		$this->requestInput	= $requestInput;
		$this->input		= $input;
	}


	public function getRequest(): IRequest
	{
		return $this->requestInput->request();
	}
	
	public function getInputSource(): IInput
	{
		return $this->input ?: $this->requestInput->params();
	}

	public function getRequestInput(): IRequestInput
	{
		return $this->requestInput;
	}
}
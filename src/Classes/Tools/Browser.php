<?php

namespace Thorazine\Hack\Classes\Tools;

use Jenssegers\Agent\Agent;

// dd($this->os()->browser()->device()->deviceType()->get(true));

class Browser {


	private $array = [];

	public $agent;


	
	public function __construct(Agent $agent)
	{
		$this->agent = new Agent();

		// return $this;
	}


	/**
	 * Get the operating system
	 *
	 * @param name (optional)
	 * @return App\Classes\Tools\Browser
	 */
	public function os($name = 'os')
	{
		$this->array[$name] = $this->agent->platform();

		return $this;
	}


	/**
	 * Get the browser
	 *
	 * @param name (optional)
	 * @return App\Classes\Tools\Browser
	 */
	public function browser($name = 'browser')
	{
		$this->array[$name] = $this->agent->browser();

		return $this;
	}


	/**
	 * Get the browser
	 *
	 * @param name (optional)
	 * @return App\Classes\Tools\Browser
	 */
	public function device($name = 'device')
	{
		$this->array[$name] = $this->agent->device();

		return $this;
	}


	/**
	 * Get the device type
	 *
	 * @param name (optional)
	 * @return App\Classes\Tools\Browser
	 */
	public function deviceType($name = 'device_type')
	{
		if($this->agent->isDesktop()) {
			$this->array[$name] = 'desktop';
		}
		elseif($this->agent->isTablet()) {
			$this->array[$name] = 'tablet';
		}
		elseif($this->agent->isPhone()) {
			$this->array[$name] = 'phone';
		}

		return $this;
	}


	/**
	 * Get the browser version
	 *
	 * @param name (optional)
	 * @return App\Classes\Tools\Browser
	 */
	public function browserAndVersion($name = 'browser_version', $connectText = ' - Version ')
	{
		$browser = $this->agent->browser();
		$this->array[$name] = $browser.$connectText.$this->agent->version($browser);

		return $this;
	}


	/**
	 * Get the data
	 *
	 * @param name (optional)
	 * @return array|object
	 */
	public function get($object = false)
	{
		if($object) {
			return json_decode(json_encode($this->array));
		}

		$return = $this->array;
		$this->array = [];
		return $return;
	}
}
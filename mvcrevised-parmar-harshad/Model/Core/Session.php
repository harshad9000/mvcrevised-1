<?php

class Model_Core_Session
{
	public function start()
	{
		if (session_status() == 1) {
		session_start();
		}
		return $this;
	}

	public function getId()
	{
		return session_id();
	}

	public function destroy()
	{
		session_destroy();
		return $this;
	}

	public function set($key,$value)
	{
		$this->start();
		$_SESSION[$key] = $value;
		return $this;
	}

	public function get($key)
	{
		$this->start();
		if (!array_key_exists($key,$_SESSION)) {
			return null;
		}
		return $_SESSION[$key];
	}

	public function unset($key)
	{
		$this->start();
		if (array_key_exists($key,$_SESSION)) {
			unset($_SESSION[$key]);
		}
		return $this;
			
	}

	public function has($key)
	{
		$this->start();
		if (array_key_exists($key,$_SESSION)) {

			return true;
		}
		return false;
	}
}
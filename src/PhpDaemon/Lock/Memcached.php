<?php

namespace Theintz\PhpDaemon\Lock;

use Theintz\PhpDaemon\Exception;
use Theintz\PhpDaemon\IPlugin;
use Theintz\PhpDaemon\Lib\Memcache;

/**
 * Use a Memcached key. The value will be the PID and Memcached ttl will be used to implement lock expiration.
 *
 * @author Shane Harter
 * @since 2011-07-28
 */
class Memcached extends Lock implements IPlugin
{
    /**
     * @var Memcache
     */
	private $memcache = false;

    /**
     * @var array
     */
	public $memcache_servers = array();

	public function __construct()
	{
		$this->pid = getmypid();
	}

	public function setup()
	{
		// Connect to memcache
		$this->memcache = new Memcache();
		$this->memcache->ns($this->daemon_name);

		// We want to use the auto-retry feature built into our memcache wrapper. This will ensure that the occasional blocking operation on
		// the memcache server doesn't crash the daemon. It'll retry every 1/10 of a second until it hits its limit. We're giving it a 1 second limit.
		$this->memcache->auto_retry(1);

		if ($this->memcache->connect_all($this->memcache_servers) === false)
			throw new Exception('Memcached::setup failed: Memcached Connection Failed');
	}

	public function teardown()
	{
		// If this PID set this lock, release it
		$lock = $this->memcache->get(Lock::$LOCK_UNIQUE_ID);
		if ($lock == $this->pid)
			$this->memcache->delete(Lock::$LOCK_UNIQUE_ID);
	}

	public function check_environment(array $errors = array())
	{
		$errors = array();

		if (false == (is_array($this->memcache_servers) && count($this->memcache_servers)))
			$errors[] = 'Memcache Plugin: Memcache Servers Are Not Set';

		if (false == class_exists('Memcache'))
			$errors[] = 'Memcache Plugin: Dependant Class "Memcache" Is Not Loaded';

		if (false == class_exists('Memcached'))
			$errors[] = 'Memcache Plugin: PHP Memcached Extension Is Not Loaded';

		return $errors;
	}

	public function set()
	{
		$lock = $this->check();
		if ($lock)
			throw new Exception('Memcached::set Failed. Existing Lock Detected from PID ' . $lock);

		$timeout = Lock::$LOCK_TTL_PADDING_SECONDS + $this->ttl;
		$this->memcache->set(Lock::$LOCK_UNIQUE_ID, $this->pid, false, $timeout);
	}

	protected function get()
	{
		$lock = $this->memcache->get(Lock::$LOCK_UNIQUE_ID);

		// Ensure we're not seeing our own lock
		if ($lock == $this->pid)
			return false;

		// If We're here, there's another lock... return the pid..
		return $lock;
	}
}
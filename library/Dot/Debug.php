<?php
/**
 * DotBoost Technologies Inc.
 * DotKernel Application Framework
 *
 * @category   DotKernel
 * @package    DotLibrary
 * @copyright  Copyright (c) 2009-2012 DotBoost Technologies Inc. (http://www.dotboost.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    $Id: Debug.php 735 2012-11-25 00:36:40Z julian $
 */

/**
 * Few useful debugging functions .
 * @category   DotKernel
 * @package    DotLibrary
 * @author     DotKernel Team <team@dotkernel.com>
 */

class Dot_Debug
{	
	/**
	 * Display debugger for db
	 * @access public
	 * @var bool
	 */	
	public $dbDebug = true;
	/**
	 * Display details for db debugger on 1st load - if false, 
	 * the user will need to click on the div to see details
	 * @access public
	 * @var bool
	 */	
	public $dbDetails = false;
	/**
	 * Allow display for db details
	 * @access public
	 * @var bool
	 */	
	public $allowDbDetails = true;
	/**
	 * Show or not total time box
	 * @access public
	 * @var bool
	 */
	public $totalTime = true;
	/**
	 * Show or not memory usage box
	 * @access public
	 * @var bool
	 */	
	public $memory_usage = true;
	/**
	 * The result of microtime() at the start of the request
	 * @access private
	 * @var string
	 */	
	private $__startTime;
	/**
	 * The module being requested
	 * @access private
	 * @var string
	 */	
	private $__module;
	
	/**
	 * Constructor
	 * @access public
	 * @param Dot_Template $tpl
	 * @return Dot_Debug
	 */
	public function __construct($tpl)
	{
		$registry = Zend_Registry::getInstance();
		$this->db = $registry['database'];
		$this->config = $registry['configuration'];
		$this->tpl = $tpl;
		$this->__startTime = $registry['startTime'];
		$this->__module = $registry->requestModule;
	}
	
	/**
	 * Set magic method
	 * @access public
	 * @param string $propriety
	 * @param object $value
	 * @return void
	 */
	public function __set($propriety, $value)
	{
		$this->$propriety = $value;
	}
	
	/**
	 * Count the end time
	 * @access private
	 * @return string
	 */
	private function _endTimer()
	{
		$endTime = microtime (true);
		$totalTime = 1000 * round (($endTime - $this->__startTime), 3);
		return $totalTime;
	}
	
	/**
	 * Format the number, show miliseconds
	 * @access private
	 * @param int $number
	 * @param bool $miliseconds [optional]
	 * @return string
	 */
	private function _numberFormat ($number, $miliseconds = false)
	{
		// show miliseconds
		if ($miliseconds)
		{
			return number_format(1000 * $number, 2, '.', ' ');
		}
		return number_format($number, 6, '.', ' ');
	}
	
	/**
	 * Display the debug variables
	 * @access public
	 * @return void
	 */
	public function show ()
	{
		if ($this->config->settings->{$this->__module}->debugbar != TRUE)
		{
			// if we don't have to show the debugbar for this module, stop here
			return;
		}
		$this->tpl->setFile('tpl_debugger', '../debugger.tpl');
		$this->tpl->setBlock('tpl_debugger', 'zf_version', 'zf_version_block');
		$this->tpl->setBlock('tpl_debugger', 'php_version', 'php_version_block');
		$this->tpl->setBlock('tpl_debugger', 'dot_version', 'dot_version_block');
		$this->tpl->setBlock('tpl_debugger', 'total_time', 'total_time_block');
		$this->tpl->setBlock('tpl_debugger', 'memory_usage', 'memory_usage_block');
		$this->tpl->setBlock('tpl_debugger', 'details_db_debug', 'details_db_debug_block');
		$this->tpl->setBlock('tpl_debugger', 'db_debug', 'db_debug_block');
		$this->tpl->setBlock('tpl_debugger', 'if_params', 'if_params_block');
		$this->tpl->setBlock('tpl_debugger', 'no_params', 'no_params_block');
		$this->tpl->setBlock('tpl_debugger', 'params', 'params_block');
		$this->tpl->setBlock('tpl_debugger', 'queries', 'queries_block');
		$this->tpl->setBlock('tpl_debugger', 'if_show_debug', 'if_show_debug_block');
		
		$this->showZFVersion();
		$this->showPHPVersion();
		$this->showDotVersion();
		
		// if we need db debuger
		if ($this->dbDebug)
		{
			$this->_showDbDebug();
		}
		if ($this->memory_usage)
		{
			$this->showMemoryUsage();
		}
		// if we need to show total time - put this last so it counts the debug of queries, memory limit, etc
		if ($this->totalTime)
		{
			$this->_showTotalTime();
		}
		$this->tpl->parse('DEBUGGER', 'tpl_debugger');		
	}

	/**
	 * Display total time 
	 * @access private
	 * @return void
	 */
	private function _showTotalTime ()
	{
		$this->tpl->setVar('TOTAL_GENERAL_TIME', $this->_endTimer());
		$this->tpl->parse('total_time_block', 'total_time', true);
	}
	
	/**
	 * Display DB querys for debug
	 * @access private
	 * @return void
	 */
	private function _showDbDebug ()
	{
		$profiler = $this->db->getProfiler();
		// lets see if we have the profiler active
		if ($profiler->getEnabled() === true)
		{
			$this->tpl->setVar('INITIAL_DISPLAY', 'none');
			// initial status
			if ($this->dbDetails)
			{
				$this->tpl->setVar('INITIAL_DISPLAY', 'block');
			}

			$longestTime = 0;
			$longestQuery = '';

			// show queries
			$count = 0;
			$profiler_queries = $profiler->getQueryProfiles();
			if (is_array($profiler_queries) && count($profiler_queries) > 0)
			{
				foreach ($profiler_queries as $query)
				{
					$bc = ($count % 2) + 1;
					$this->tpl->setVar('DEBUG_CLASS', 'debugger_'.$bc);
					$this->tpl->setVar('QUERY_COUNT', $count++);
					$this->tpl->setVar('QUERY_TIME', $this->_numberFormat($query->getElapsedSecs(), true));
					$this->tpl->setVar('QUERY_TEXT', $query->getQuery());
					if ($query->getElapsedSecs() > $longestTime)
					{
						$longestTime = $query->getElapsedSecs();
						$longestQuery = $query->getQuery();
					}

					// show query params
					$queryParams = $query->getQueryParams();
					// a filter to prevent XSS
					$tagFilter = new Zend_Filter_StripTags();
					if (count($queryParams) > 0)
					{
						foreach ($queryParams as $key => $val)
						{
							$this->tpl->setVar('QUERY_PARAMS', $tagFilter->filter($val));
							$this->tpl->parse('params_block', 'params', true);
						}
						$this->tpl->parse('if_params_block', 'if_params', true);
					}
					else 
					{
						$this->tpl->parse('no_params_block', 'no_params', true);
					}
					$this->tpl->parse('queries_block', 'queries', true);
					$this->tpl->parse('if_params_block', '');
					$this->tpl->parse('no_params_block', '');
					$this->tpl->parse('params_block', '');
				}
			}
			$totalTime = $profiler->getTotalElapsedSecs();
			$queryCount = $profiler->getTotalnumQueries();
			// show aditional information
			$this->tpl->setVar('TOTAL_QUERIES', $queryCount);
			$this->tpl->setVar('TOTAL_TIME', $this->_numberFormat($totalTime, true));
			$this->tpl->setVar('AVERAGE_QUERY_TIME', $this->_numberFormat($totalTime / $queryCount, true));
			$this->tpl->setVar('QUERIES_PER_SECOND', ceil($queryCount / $totalTime));
			$this->tpl->setVar('LONGEST_QUERY', $longestQuery);
			$this->tpl->setVar('LONGEST_QUERY_TIME', $this->_numberFormat($longestTime, true));
			// parse final blocks
			if ($this->allowDbDetails)
			{
				$this->tpl->parse('details_db_debug_block', 'details_db_debug', true);
			}
			else 
			{
				$this->tpl->parse('db_debug_block', 'db_debug', true);
			}
			$this->tpl->parse('if_show_debug_block', 'if_show_debug', true);
		}
	}
	
	/**
	 * Display memory usage 
	 * @access public
	 * @return void
	 */
	public function showMemoryUsage ()
	{
		$memory_limit = round((memory_get_usage(TRUE) / pow(10, 6)), 2);
		$this->tpl->setVar('MEMORY_USAGE', $memory_limit);
		$this->tpl->parse('memory_usage_block', 'memory_usage', true);
	}
	
	/**
	 * Display ZF Version
	 * @access public
	 * @return void
	 */
	public function showZFVersion ()
	{
		$this->tpl->setVar('ZF_VERSION', Zend_Version::VERSION);
		$this->tpl->parse('zf_version_block', 'zf_version', true);
	}
	
	/**
	 * Display PHP version
	 * @access public
	 * @return void
	 */
	public function showPHPVersion ()
	{
		$this->tpl->setVar('PHP_VERSION', phpversion());
		$this->tpl->parse('php_version_block', 'php_version', true);
	}
	
	/**
	 * Display DotKernel version
	 * @access public
	 * @return void
	 */
	public function showDotVersion ()
	{
		$this->tpl->setVar('DOT_VERSION', Dot_Kernel::VERSION);
		$this->tpl->parse('dot_version_block', 'dot_version', true);
	}
}
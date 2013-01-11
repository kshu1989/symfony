<?php

/**
 * job actions.
 *
 * @package    peimission
 * @subpackage job
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class jobActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->jobeet_jobs = Doctrine_Core::getTable('JobeetJob')->getJobs();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->a = $request->getParameter('id');
		$this->job = Doctrine::getTable('JobeetJob')->getJobById($request->getParameter('id'));
	}

	public function executeShowcategory(sfWebRequest $request){
		$this->jobeet_category_jobs = Doctrine::getTable('JobeetJob')->getJobsByCategoryId($request->getParameter('id'));
	}
}

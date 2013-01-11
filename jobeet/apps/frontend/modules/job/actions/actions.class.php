<?php

/**
 * job actions.
 *
 * @package    jobeet
 * @subpackage job
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class jobActions extends sfActions
{

	public function executeSearch(sfWebRequest $request)
	{
		$this->forwardUnless($query = $request->getParameter('query'), 'job', 'index');

		$this->jobs = Doctrine_Core::getTable('JobeetJob') ->getForLuceneQuery($query);

		if ($request->isXmlHttpRequest())
		{
			if ('*' == $query || !$this->jobs)
			{
				return $this->renderText('No results.');
			}

			return $this->renderPartial('job/list', array('jobs' => $this->jobs));
		}
	}

	public function executeIndex(sfWebRequest $request)
	{
		if (!$request->getParameter('sf_culture'))
		{
			if ($this->getUser()->isFirstRequest())
			{
				$culture = $request->getPreferredCulture(array('en', 'fr'));
				$this->getUser()->setCulture($culture);
				$this->getUser()->isFirstRequest(false);
			}
			else
			{
				$culture = $this->getUser()->getCulture();
			}

			$this->redirect('localized_homepage');
		}

		$this->categories = Doctrine_Core::getTable('JobeetCategory')->getWithJobs();
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new JobeetJobForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->form = new JobeetJobForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->form = new JobeetJobForm($this->getRoute()->getObject());
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->form = new JobeetJobForm($this->getRoute()->getObject());
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$job = $this->getRoute()->getObject();
		$job->delete();

		$this->redirect('job/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind(
				$request->getParameter($form->getName()),
				$request->getFiles($form->getName())
		);

		if ($form->isValid())
		{
			$job = $form->save();

			$this->redirect('job_show', $job);
		}
	}

	public function executeShow(sfWebRequest $request)
	{

		$this->job = $this->getRoute()->getObject();
		$this->getUser()->addJobToHistory($this->job);
		// 		if($request->getParameter('id')){
		// 			$this->job = Doctrine::getTable('JobeetJob')-> find($request->getParameter('id'));
		// 		}else{
		// 			$this->job = Doctrine::getTable('JobeetJob')-> findByToken($request->getParameter('token'));
		// 		}

		// 		$this->forward404Unless($this->job);
	}

	public function executePublish(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$job = $this->getRoute()->getObject();
		$job->publish();

		$this->getUser()->setFlash('notice', sprintf('Your job is now online for %s days.', sfConfig::get('app_active_days')));

		$this->redirect('job_show_user', $job);
	}
}
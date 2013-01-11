<?php

/**
 * JobeetJobTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class JobeetJobTable extends Doctrine_Table
{
	/**
	 * Returns an instance of this class.
	 *
	 * @return object JobeetJobTable
	 */
	public static function getInstance()
	{
		return Doctrine_Core::getTable('JobeetJob');
	}

	public function getJobs(){
		$q = $this->createQuery();
		return $q->execute();
	}

	public function getJobById($id){
		return JobeetJobTable::getInstance()->find($id);
	}

	public function getJobsByCategoryId($category_id){

		// 		return JobeetJobTable::getInstance()->findByCategoryId($category_id);
		$q = Doctrine_Query :: create()
		->select ('*')
		->from('JobeetJob j, j.JobeetCategory c')
		->where('c.id = ?', $category_id);

		return  $q->execute();
	}
}
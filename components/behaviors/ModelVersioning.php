<?php
/**
 * 
 */
namespace app\components\behaviors;

use yii\db\ActiveRecord;
use yii\db\Query;
use Yii;
class ModelVersioning extends  \yii\base\Behavior
{
	
	/**
	 * Params that can be setted when declaring the
	 * behavior.
	 * There's an additional param that can be used to 
	 * specify the version table name: 'VersionTable'.
	 * If not setted it's value is {tableName}_version
	 */
	public $createdByField = "created_by";
	public $createdAtField = "created_time";
	public $versionCommentField = "version_comment";
	public $versionField = "version";
	public $removeVersioningOnDelete = true;
	

	protected $_createdAt = "";
	protected $_createdBy = "";
	protected $_versionComment = "";
	protected $_lastVersion;
	protected $_versionTable;

        
      
        public function events() {
            $events = [
                ActiveRecord::EVENT_AFTER_INSERT=>'afterSave',
                ActiveRecord::EVENT_AFTER_DELETE=>'afterDelete',
                ActiveRecord::EVENT_AFTER_UPDATE=>'afterSave',
                ];
            return array_merge(parent::events(),$events);
        }

        public function afterSave($event)
	{
		Yii::$app->db->createCommand()->insert($this->versionTable, $this->versionedAttributes)->execute();
                
		$version = Yii::$app->db->lastInsertID;
		Yii::$app->db->createCommand()->update($this->owner->tableName(), [
			$this->versionField => $version,
			], 'id=:id', [':id' => $this->owner->id]
		)->execute();
		$this->owner->version = $version;
		$this->_lastVersion = $version;
	}

	public function afterDelete($event)
	{
		if($this->removeVersioningOnDelete) {
			$this->deleteVersioning(false);
		}
	}

	/**
	 * Return the name of the version table for the model
	 * Default to {tableName}_version
	 * @return String return the name of the version table for the model
	 */
	public function getVersionTable()
	{
		if($this->_versionTable !== null) {
			return $this->_versionTable;
		} else {
			return $this->owner->tableName() . "_version";
		}
	}

	public function setVersionTable($table)
	{
		$this->_versionTable = $this->setAttribute($table);
	}

	public function setVersionCreatedBy($createdBy)
	{
		$this->_createdBy = $this->setAttribute($createdBy);
	}

	public function getVersionCreatedBy()
	{
		return $this->_createdBy;
	}

	public function setVersionComment($versionComment)
	{
		$this->_versionComment = $this->setAttribute($versionComment);
	}

	public function getVersionComment()
	{
		return $this->_versionComment;
	}

	public function getVersionCreatedAt()
	{
		if($this->_createdAt !== null) {
			return $this->_createdAt;
		} else {
			return time();
		}
	}

	public function setVersionCreatedAt($versionCreatedAt)
	{
		$this->_createdAt = $versionCreatedAt;
	}

	/**
	* @return Return if the model is at its last version
	*/
	public function isLastVersion() 
	{
		return $this->owner->version === $this->getLastVersionNumber();
	}
	
	/**
	* @return int Return the version number of the model
	*/
	public function getVersion() 
	{
		if ($this->owner->version == null) {
			return 0;
		} else {
			return $this->owner->version;
		}
	}
	
	/**
	* @return int Return the last version number of the model
	*/
	public function getLastVersionNumber()
	{
		if($this->_lastVersion !== null) {
			return $this->_lastVersion;
		} else {
			$lastVersion = Yii::$app->db->createCommand()
			    ->select("MAX($this->versionField) as version_number")
			    ->from($this->versionTable)
			    ->where('id=:id', [':id'=>$this->owner->primaryKey])
			    ->queryRow();
			$this->_lastVersion = $lastVersion['version_number'];
			return $this->_lastVersion;
		}
			
	}

	/**
	 * Remove all the versioned data from the version table
	 * @param  boolean $updateVersion Wheither or not the original model version must be resetted
	 */
	public function deleteVersioning($updateVersion = true)
	{
		Yii::$app->db->createCommand()->delete($this->versionTable, 'id=:id',[
			':id'=>$this->owner->primaryKey
			]
		)->execute();
		if($updateVersion) {
			Yii::$app->db->createCommand()->update($this->owner->tableName(), [
				$this->versionField => 1,
				], 'id=:id', [':id' => $this->owner->id]
			)->execute();
		}
	}

	/**
	 * Return all the versions of the Active Record Object
	 * @return array List of the different versions of the object
	 */
	public function getAllVersions()
	{
            $query=new Query;
            
            $allVersionsArray = $query->
                        select('*')
			    ->from($this->versionTable)
			    ->where('id=:id', [':id'=>$this->owner->primaryKey])
			    ->orderBy('version ASC')
			    ->createCommand()->queryAll();
	    if(!empty($allVersionsArray)) {
	    	return $this->populateActiveRecords($allVersionsArray);	
	    } else {
	    	return [];
	    }
	}
	
	/**
	* Return the n last versions of the model.
	* @param int $number Number of the last versions to return. Default to 1.
	* @return array return an array containing the last versions or 
	* an empty array if no versions are available
	*/
	public function getLastVersions($number = 1)
	{
            $query=new Query;
            $lastVersionsArray = $query
			    ->select('*')
			    ->from($this->versionTable)
			    ->where('id=:id', [':id'=>$this->owner->primaryKey])
			    ->orderBy('version DESC')
			    ->limit($number)
			    ->createCommand()->queryAll();
	    if(!empty($lastVersionsArray)) {
	    	return $this->populateActiveRecords($lastVersionsArray);
	    } else {
	    	return [];
	    }
	}
        
	/**
	* Return the n last versions of the model.
	* @param int $number Number of the last versions to return. Default to 1.
	* @return array return an array containing the last versions or 
	* an empty array if no versions are available
	*/
	public function getVersionByCreateDate($date)
	{
            $query=new Query;
            $lastVersionsArray = $query
			    ->select('*')
			    ->from($this->versionTable)
			    ->where('id=:id', [':id'=>$this->owner->primaryKey])
                            ->andWhere(['<=','date_format(version_created_at,\'%Y-%m-%d\')',Yii::$app->formatter->asDate($date,'php:Y-m-d')])
			    ->orderBy('version DESC')
			    ->limit(1)
			    ->createCommand()->queryOne();
	    if(!empty($lastVersionsArray)) {
	    	return $lastVersionsArray;
	    } else {
	    	return [];
	    }
	}
	
	/**
	* Return a version of the model or false if the version number doesn't exist
	* @param int $versionNumber Number of the version to return
	* @return mixed return an active record corresponding to the version number
	* or false if it doesn't exist in the db
	*/
	public function getOneVersion($versionNumber) 
	{
            $query=new Query;
            $versionArray = $query
			    ->select('*')
			    ->from($this->versionTable)
			    ->where(
			    	"id=:id AND $this->versionField=:version", 
			    	[
                                    ':id'=>$this->owner->primaryKey, 
                                    ':version'=>$versionNumber,
                                ]
		    	)->createCommand()->queryOne();
	    if($versionArray) {
	    	return $this->populateNewRecord($versionArray, get_class($this->owner));
	    } else {
	    	return false;
	    }
	    
	}
	
	/**
	* Convert the model to the given version
	* @param int $versionNumber The version to convert to
	* @return bool true if everything went fine, false otherwise
	*/
	public function toVersion($versionNumber)
	{
            $query=new Query;
            $versionArray = $query
			    ->select('*')
			    ->from($this->versionTable)
			    ->where(
			    	"id=:id AND $this->versionField=:version", 
			    	[
                                    ':id'=>$this->owner->primaryKey, 
                                    ':version'=>$versionNumber,
                                ]
		    	)->createCommand()->queryOne();
	    if($versionArray) {
	    	$this->populateActiveRecord($versionArray, $this->owner);
	    	return true;
	    } else {
	    	return false;
	    }
	}
	
	/**
	* Compare 2 versions of the model
	* the number of the 2 version
	* @return mixed return an array containing the differences or false
	* if a version hasn't been found in the db
	*/
	public function compareVersions($version1, $version2)
	{
            $query=new Query;
            $versionsArray = $query
			    ->select('*')
			    ->from($this->versionTable)
			    ->where(
					['and', 'id=:id', ['or', $this->versionField . '=:version1', $this->versionField . '=:version2']],
					[
						':id'=>$this->owner->primaryKey,
						':version1' => $version1,
						':version2' => $version2,
					]
				)
			    ->orderBy("$this->versionField ASC")
			    ->createCommand()->queryAll();
	    if(!empty($versionsArray)&& count($versionsArray) == 2) {
			//Watch attributes changing from one version to the other and put them in the array
			//penser � unset les attributs de version (version, comment, created by, created at)
			$differences = [];
			foreach($versionsArray[0] as $index => $value) {
				if(isset($versionsArray[1][$index]) && $value !== $versionsArray[1][$index]) {
					$differences[$index] = [$versionsArray[0]['version'] => $value, $versionsArray[1]['version'] => $versionsArray[1][$index]];
				}
			}
			$differences = $this->unsetVersionedAttributes($differences);
	    	return $differences;
	    } else {
	    	return false;
	    }
	}
	
	/**
	* Compare the actual model to the given version
	* @param int $versionNumber Version number to compare to
	* @return mixed An array containing the differences or false if the version number
	* doesn't exist in the db
	*/
	public function compareTo($versionNumber)
	{
            $query=new Query;
            $thisVersion = $this->owner->getAttributes(false);
		$versionArray = $query
			    ->select('*')
			    ->from($this->versionTable)
			    ->where(
			    	"id=:id AND $this->versionField=:version", 
			    	[
                                    ':id'=>$this->owner->primaryKey, 
                                    ':version'=>$versionNumber,
                                ]
		    	)->createCommand()->queryOne();
		if($versionArray) {
			$differences = [];
			$thisVersion = $this->unsetVersionedAttributes($this->owner->getAttributes(false));
			foreach($thisVersion as $index => $value) {
				if(isset($versionArray[$index]) && $value !== $versionArray[$index]) {
					$differences[$index] = ['actual' => $value, $versionArray[$this->versionField] => $versionArray[$index]];
				}
			}
			return $differences;
		} else {
			return false;
		}
	}
	
	/**
	* Get the attributes to add to the version table:
	* - the attributes from the model (also the not safe ones)
	* - The version attributes (createdBy, ...)
	* @return array an array containing the attributes
	*/
	protected function getVersionedAttributes()
	{
		$this->VersionCreatedAt = date('Y-m-d H:i:s', time());

		$versionedAttributes = $this->owner->attributes;
		$versionedAttributes[$this->createdByField] = $this->versionCreatedBy;
		$versionedAttributes[$this->createdAtField] = $this->VersionCreatedAt;
		$versionedAttributes[$this->versionCommentField] = $this->versionComment;
		//we don't save the actual version number in the version table since it'll be automatically incremented
		unset($versionedAttributes[$this->versionField]);
		return $versionedAttributes;
	}
	
	/**
	* Unset the versionned attributes that could be returned from sql requests
	* @param array $array the array to unset
	*/
	protected function unsetVersionedAttributes($array)
	{
		unset($array[$this->versionField]);
		unset($array[$this->createdAtField]);
		unset($array[$this->createdByField]);
		unset($array[$this->versionCommentField]);
		return $array;
	}

	protected function setAttribute($value)
	{
		if($value == null) {
			return "";
		} else {
			return $value;
		}
	}
	
	/**
	* Create some Active Records from an array of their values
	* @param array $values Array of the values returned from the db
	* @return array return an array containing the CactiveRecords models
	*/
	protected function populateActiveRecords($values) 
	{
		$className = get_class($this->owner);
		$activeRecords = [];
		foreach($values as $version) {	
			$activeRecords[] = $this->populateNewRecord($version, $className);
		}
		return $activeRecords;
	}
	
	/**
	* Create a new active record object and fill it with the given value
	* @param array $values the values that the active record object need to be filled with
	* @param string $className Name of the class object to create
	* @return CActiveRecord Return the newly created object populated
	*/
	protected function populateNewRecord($values, $className)
	{
		return $this->populateActiveRecord($values, new $className());
	}
	
	/**
	* Populate the given Active Record with the given values.
	* @param array $values The values to put in the Active record
	* @param CActiveRecord $model the object to populate
	* @return CActiveRecord return the populate active record
	*/
	protected function populateActiveRecord($values, $model)
	{
		$model->versionComment = $values[$this->versionCommentField];
		$model->versionCreatedBy = $values[$this->createdByField];
		$model->versionCreatedAt = $values[$this->createdAtField];
		$model->setAttributes($values, false);
		return $model;
	}
	
}

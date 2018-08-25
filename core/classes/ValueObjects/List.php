<?php

class TodoList{
    protected $listId;
    protected $listTitle;
    protected $listBy;
    protected $listActive;

    protected $tasks = array();

    /**
     * Get the value of listId
     */ 
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * Set the value of listId
     *
     * @return  self
     */ 
    public function setListId($listId)
    {
        $this->listId = $listId;
    }

    /**
     * Get the value of listTitle
     */ 
    public function getListTitle()
    {
        return $this->listTitle;
    }

    /**
     * Set the value of listTitle
     *
     * @return  self
     */ 
    public function setListTitle($listTitle)
    {
        $this->listTitle = $listTitle;
    }

    /**
     * Get the value of listBy
     */ 
    public function getListBy()
    {
        return $this->listBy;
    }

    /**
     * Set the value of listBy
     *
     * @return  self
     */ 
    public function setListBy($listBy)
    {
        $this->listBy = $listBy;
    }

    /**
     * Get the value of listActive
     */ 
    public function getListActive()
    {
        return $this->listActive;
    }

    /**
     * Set the value of listActive
     *
     * @return  self
     */ 
    public function setListActive($listActive)
    {
        $this->listActive = $listActive;
    }

    /**
     * Get the value of tasks
     */ 
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Set the value of tasks
     *
     * @return  self
     */ 
    public function addTasksToList($tasks)
    {
        array_push($this->tasks = $task);
    }

    public function fetchListFromDb($fetchData) {
        $this->setListId($fetchData['list_id']);
        $this->setListTitle($fetchData['listtitle']);
        $this->setListBy($fetchData['listBy']);
        $this->setListActive($fetchData['listActive']);

        if(isset($fetchData['tasks']) && !empty($fetchData['tasks'])){
            foreach($fetchData['tasks'] as $task) {
                $this->addTasksToList($task);
            }
        }
    }
}
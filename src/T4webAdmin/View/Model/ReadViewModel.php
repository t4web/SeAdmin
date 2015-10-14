<?php

namespace T4webAdmin\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Entity;

class ReadViewModel extends ViewModel
{
    /**
     * @var Entity
     */
    private $mainEntity;

    /**
     * @var FormViewModel
     */
    private $formViewModel;

    /**
     * @return Entity
     */
    public function getMainEntity()
    {
        return $this->mainEntity;
    }

    /**
     * @param Entity $mainEntity
     */
    public function setMainEntity(Entity $mainEntity)
    {
        $this->mainEntity = $mainEntity;
    }

    /**
     * @return FormViewModel
     */
    public function getFormViewModel()
    {
        return $this->formViewModel;
    }

    /**
     * @param FormViewModel $formViewModel
     */
    public function setFormViewModel($formViewModel)
    {
        $this->formViewModel = $formViewModel;
    }
}

<?php

namespace App\Application\Common\Controller;

use App\Application\Common\Repository\BaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BaseController
 * @package App\Application\Common\Controller
 */
class BaseController extends AbstractController
{
    const FLASH_INFO = 'info';

    /**
     * @param BaseRepository $repository
     * @param $id
     * @return mixed
     */
    protected function findByRepository(BaseRepository $repository, $id)
    {
        $entity = $repository->find($id);
        //$this->ifNotFound404($entity);

        return $entity;
    }

    /**
     * @param $entity
     */
    protected function ifNotFound404($entity)
    {
        if (!$entity) {
            throw new NotFoundHttpException();
        }
    }
}

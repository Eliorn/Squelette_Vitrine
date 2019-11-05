<?php

namespace PR\VitrineBundle\Repository;

/**
 * GalleryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GalleryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getMaxOrder(){
        $query = $this->createQueryBuilder('g');
        $query->select('g, MAX(g.galleryorder) AS max_order');

        return $query->getQuery()->getResult();
    }
}

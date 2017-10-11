<?php

namespace CitiesBundle\Repository;

/**
 * VilleRepository
 */
class VilleRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste de villes par page
     * @param $criteres
     * @param array $order
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getVillePaginated($offset = 0, $limit = 100, $criteres = array(), $order = array('name'=>'ASC'))
    {
        return $this->findBy(
            $criteres,
            $order,
            $limit,
            $offset
        );
    }

    /**
     * Retourne la ville par son slug, si le slug de sa region et departement ne correspondent pas à la ville, cela renvoie une exception
     * @param string $slug
     * @param string $dptSlug
     * @param string $regionSlug
     * @return null|object
     * @throws \Exception
     */
    public function getBySlug($slug, $dptSlug, $regionSlug)
    {
        $ville = $this->findOneBy(
            array('slug' => $slug)
        );
        if ( $ville->getRegion()->getSlug() == $regionSlug && $ville->getDepartement()->getSlug() == $dptSlug) {
            return $ville;
        } else {
            throw new \Exception("L'url ne correspond pas à une ville de france");
        }
    }


    public function getCountVillePaginated($criteres = array())
    {
        return count($this->findBy(
            $criteres
        ));
    }

    /**
     * Return collection of the most important city of france
     * @param int $population
     * @return mixed
     */
    public function getVillesImportantes($population = 100000)
    {
        $query = $this->_em->createQueryBuilder()
                ->select('ville.name, ville.numberPopulation')
                ->from($this->_entityName, 'ville')
                ->where('ville.numberPopulation >= :population')
                /*->orderBy('ville.numberPopulation', 'DESC')*/
                ->setParameter('population', $population);

        return $query->getQuery()->getArrayResult();
    }
}

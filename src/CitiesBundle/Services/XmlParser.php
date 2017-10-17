<?php


namespace CitiesBundle\Services;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class XmlParser
{

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function saveRegionGPS($path_xml, OutputInterface $output)
    {
        $xml = simplexml_load_file($path_xml);
        $regionRepo = $this->em->getRepository('CitiesBundle:Region');

        $output->writeln("Parcours du fichier kml");

        foreach($xml->Document->Folder->Placemark as $placemark) {

            $name = $placemark->name;
            $coordinates = $placemark->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates;

            $output->writeln("Region: ".$name);

            $region = $regionRepo->findOneBy(
              array('name' => $name)
            );
            if (!is_null($region)) {
                $region->setCoordinates($coordinates);
                $this->em->persist($region);
            } else {
                $output->writeln("Aucune region ne correspond au nom ".$name);
            }
        }

        $this->em->flush();
    }

}
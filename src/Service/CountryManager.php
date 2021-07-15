<?php

namespace App\Service;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CountryManager
{
    private $entityManager;
    private $countryRepository;
    private $urlManager;

    public function __construct(EntityManagerInterface $entityManager, CountryRepository $countryRepository, UrlManager $urlManager)
    {
        $this->entityManager = $entityManager;
        $this->countryRepository = $countryRepository;
        $this->urlManager = $urlManager;
    }

    /**
     *  return int with the number of countries
     */
    public function getNumberCountries()
    {
        return $this->countryRepository->countCountry();
    }

    /**
     *  return bool with if there is data in ddbb
     */
    public function countriesAlreadyCreates()
    {
        if ($this->getNumberCountries()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate all countries in ddbb by public API
     */
    public function generateCountries($url)
    {
        if (true === $this->countriesAlreadyCreates()) {
            return array(
                'created' => false,
                'message' => 'Countries already created',
            );
        }

        if (false === $this->urlManager->urlExist($url)) {
            return array(
                'created' => false,
                'message' => 'The url ' . $url . ' does not exist',
            );
        }

        $dataCountries = json_decode(file_get_contents($url), true);
        
        foreach ($dataCountries as $dataCountry) { 
            $country = new Country();
            $country->setName($dataCountry['name']);
            $country->setJson(array($dataCountry));
            $this->entityManager->persist($country);
            $this->entityManager->flush();
        }

        return array(
            'created' => true,
            'message' => 'countries created correctly',
        );
    }
}
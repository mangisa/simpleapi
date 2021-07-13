<?php

namespace App\Controller;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(CountryRepository $countryRepository): Response
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/names_db_get", name="names_db_get", methods={"GET"})
     */
    public function namesDBGet(CountryRepository $countryRepository): JsonResponse
    {
        return new JsonResponse($countryRepository->findByNameId(), 200);
    }
    
    /**
     * @Route("/db_get/{id}", name="country_db_get", methods={"GET"})
     */
    public function countryDBGet(Country $country): JsonResponse
    {
        return new JsonResponse($country->getJson(), 200);
    }

    /**
     * @Route("/create_countries", name="create_countries", methods={"GET"})
     */
    public function createCountries(): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dataCountries = json_decode(file_get_contents('https://restcountries.eu/rest/v2/all'), true);
        
        foreach ($dataCountries as $dataCountry) {

            $countryData = array($dataCountry);
            $countryName = $dataCountry['name'];
 
            $country = new Country();

            $country->setName($countryName);
            $country->setJson($countryData);
            $entityManager->persist($country);
            $entityManager->flush();
        }        

        return new JsonResponse(
            array(
                'correct_create' => true,
            ), 200
        );
    }   
}

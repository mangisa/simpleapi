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
        return $this->render('default/index.html.twig', array(
            'dateAlreadyCreates' => $this->dateAlreadyCreates($countryRepository),
        ));
    }

    /**
     * @Route("/names_db_get", name="names_db_get", methods={"GET"})
     */
    public function namesDBGet(CountryRepository $countryRepository): JsonResponse
    {
        return new JsonResponse($countryRepository->findByNameId(), 200);
    }
    
    /**
     * @Route("/country_db_get/{id}", name="country_db_get", methods={"GET"})
     */
    public function countryDBGet(Country $country): JsonResponse
    {
        return new JsonResponse($country->getJson(), 200);
    }

    /**
     * @Route("/create_countries", name="create_countries", methods={"GET"})
     */
    public function createCountries(CountryRepository $countryRepository): JsonResponse
    {
        if ($this->dateAlreadyCreates($countryRepository)) {
            return new JsonResponse(
                array(
                    'created' => false,
                    'message' => 'Debe tener vacía la tabla country para poder importar datos por api',
                ), 200
            );
        } 

        $entityManager = $this->getDoctrine()->getManager();
        $dataCountries = json_decode(file_get_contents('https://restcountries.eu/rest/v2/all'), true);
        
        foreach ($dataCountries as $dataCountry) { 
            $country = new Country();

            $country->setName($dataCountry['name']);
            $country->setJson(array($dataCountry));
            $entityManager->persist($country);
            $entityManager->flush();
        }        

        return new JsonResponse(
            array(
                'created' => true,
                'message' => 'Se han creado los elementos en bbdd',
            ), 200
        );
    } 
    
    private function dateAlreadyCreates($countryRepository)
    {
        $numberCountries = $countryRepository->countCountry();

        if ($numberCountries) {
            return true;
        } else {
            return false;
        }
    }
}

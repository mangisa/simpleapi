<?php

namespace App\Controller;

use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Service\CountryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', array(
            'url_contry'        => $this->getParameter('app.url_country'),
            'url_all_countries' => $this->getParameter('app.url_all_countries'),
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
    public function createCountries(CountryManager $countryManager): JsonResponse
    {
        $createCountries = $countryManager->generateCountries($this->getParameter('app.url_all_countries'));
        
        return new JsonResponse(
            array(
                'created' => $createCountries['created'],
                'message' => $createCountries['message'],
            ), 200
        );
    } 
}

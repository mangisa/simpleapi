<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $data = json_decode(file_get_contents('https://restcountries.eu/rest/v2/all?fields=name'), true);
        
        $countryNames = array();
        foreach ($data as $key => $arrayCountry) {
            array_push($countryNames, $arrayCountry['name']);
        }

        return $this->render('default/index.html.twig', [
            'my_mail' => $this->getParameter('app.admin_email'),
            'countries_names' => $countryNames,
        ]);
    }

    /**
     * @Route("/api_get/{country}", name="country_api_get", methods={"GET"})
     */
    public function countryApiGet($country): JsonResponse
    {
        $url = 'https://restcountries.eu/rest/v2/name/' . $country;
        $data = json_decode(file_get_contents($url), true);

        return new JsonResponse(
            array(
                'data' => reset($data),
                'country' => $country,
            ), 200
        );
    }

    /**
     * @Route("/db_get/{country}", name="country_db_get", methods={"GET"})
     */
    public function countryDBGet($country): JsonResponse
    {
        $url = 'https://restcountries.eu/rest/v2/name/' . $country;
        $data = json_decode(file_get_contents($url), true);

        return new JsonResponse(
            array(
                'data' => reset($data),
                'country' => $country,
            ), 200
        );
    }

    
}

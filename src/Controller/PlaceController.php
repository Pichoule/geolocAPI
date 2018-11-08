<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Place;

class PlaceController extends AbstractController
{
    /**
     * @Route("/place", name="place")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository(Place::class)->findAll();

        $data = [];
        foreach ($places as $place) {
            array_push($data, [
                'id' => $place->getId(),
                'category_id' => $place->getCategoryId(),
                'name' => $place->getName(),
                'adress' => $place->getAdress(),
                'postal_code' => $place->getPostalCode(),
                'city' => $place->getCity(),
                'latitude' => $place->getLatitude(),
                'longitude' => $place->getLongitude(),
                'user_id' => $place->getUserId()
            ]);
        }

        $code = JsonResponse::HTTP_OK;
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

     /**
     * @Route("/", name="place_create", methods="POST")
     */
    public function place_create(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $input = json_decode($request->getContent(), true);

        $place = new Place();
        $place->setName($input['name']);
        $place->setCategoryId($input['category_id']);
        $place->setAdress($input['adress']);
        $place->setPostalCode($input['postal_code']);
        $place->setCity($input['city']);
        $place->setLatitude($input['latitude']);
        $place->setLongitude($input['longitude']);
        $place->setUserId($input['user_id']);

        $em->persist($place);
        $em->flush();

         $data = [
                'id' => $place->getId(),
                'nom' => $place->getName(),
                'user_id' => $place->getUserId(),
                'category_id' => $place->getCategoryId(),
                'adress' => $place->getAdress(),
                'postal_code' => $place->getPostalCode(),
                'city' => $place->getCity(),
                'latitude' => $place->getLatitude(),
                'longitude' => $place->getLongitude()
            ];
        $code = JsonResponse::HTTP_CREATED;

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }
}

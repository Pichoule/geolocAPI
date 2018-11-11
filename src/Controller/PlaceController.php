<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Place;
use App\Entity\Category;
use App\Entity\User;

/**
     * @Route("/place")
     */

class PlaceController extends AbstractController
{
    /**
     * @Route("", name="place", methods="GET")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository(Place::class)->findAll();

        $data = [];
        foreach ($places as $place) {
            array_push($data, [
                'id' => $place->getId(),
                'category_id' => $place->getCategoryId()->getId(),
                'name' => $place->getName(),
                'adress' => $place->getAdress(),
                'postal_code' => $place->getPostalCode(),
                'city' => $place->getCity(),
                'latitude' => $place->getLatitude(),
                'longitude' => $place->getLongitude(),
                'user_id' => $place->getUserId()->getId()
            ]);
        }

        $code = JsonResponse::HTTP_OK;
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

     /**
     * @Route("/{id}", name="place_id", methods="GET")
     */
    public function place_id(Place $place): JsonResponse
    {
        if(is_null($place)) {
           $data = [];
           $code = JsonResponse::HTTP_NOT_FOUND;
        } else {
            $data = [
                 'id' => $place->getId(),
                'category_id' => $place->getCategoryId()->getId(),
                'name' => $place->getName(),
                'adress' => $place->getAdress(),
                'postal_code' => $place->getPostalCode(),
                'city' => $place->getCity(),
                'latitude' => $place->getLatitude(),
                'longitude' => $place->getLongitude(),
                'user_id' => $place->getUserId()->getId()
            ];
        }

        $code = JsonResponse::HTTP_OK;
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

     /**
     * @Route("/category/{id}", name="places_category_id", methods="GET")
     */
    public function places_category_id(Category $category): JsonResponse
    {
        $data = [];
        $code = JsonResponse::HTTP_OK;

        if (!is_null($category)) {
            $places = [];
            $em = $this->getDoctrine()->getManager();

            foreach ($category->getPlaces() as $place) {
                $p = [
                    'id' => $place->getId(),
                    'name' => $place->getName(),
                    'address' => $place->getAdress(),
                    'postal_code' => $place->getPostalCode(),
                    'city' => $place->getCity(),
                    'latitude' => $place->getLatitude(),
                    'longitude' => $place->getLongitude()
                ];
                array_push($places,$p);
                $data = [
                    'category_id' => $category->getId(),
                    'place' => $places
                ];
            }
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

     /**
     * @Route("", name="place_create", methods="POST")
     */
    public function place_create(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $input = json_decode($request->getContent(), true);

        $category =  $em->getRepository(Category::class)->findOneBy(['id'=>$input['category_id']]);
        $user = $em->getRepository(User::class)->findOneBy(['id'=>$input['user_id']]);

        $place = new Place();
        $place->setName($input['name']);
        $place->setCategoryId($category);
        $place->setAdress($input['adress']);
        $place->setPostalCode($input['postal_code']);
        $place->setCity($input['city']);
        $place->setLatitude($input['latitude']);
        $place->setLongitude($input['longitude']);
        $place->setUserId($user);

        $em->persist($place);
        $em->flush();

         $data = [
                'id' => $place->getId(),
                'name' => $place->getName(),
                'user_id' => $place->getUserId()->getId(),
                'category_id' => $place->getCategoryId()->getId(),
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

     /**
     * @Route("/{id}", name="place_update", methods="PUT")
     */
    public function place_update(Place $place, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $input = json_decode($request->getContent(), true);

        $category =  $em->getRepository(Category::class)->findOneBy(['id'=>$input['category_id']]);
        $user = $em->getRepository(User::class)->findOneBy(['id'=>$input['user_id']]);

        if (!is_null($place)){
            $place->setName($input['name']);
            $place->setCategoryId($category);
            $place->setAdress($input['adress']);
            $place->setPostalCode($input['postal_code']);
            $place->setCity($input['city']);
            $place->setLatitude($input['latitude']);
            $place->setLongitude($input['longitude']);
            $place->setUserId($user);
            $em->flush();

            $data = [
                'id' => $place->getId(),
                'name' => $place->getName(),
                'user_id' => $place->getUserId()->getId(),
                'category_id' => $place->getCategoryId()->getId(),
                'adress' => $place->getAdress(),
                'postal_code' => $place->getPostalCode(),
                'city' => $place->getCity(),
                'latitude' => $place->getLatitude(),
                'longitude' => $place->getLongitude()
                ];
                $code = JsonResponse::HTTP_ACCEPTED;

                
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

    /**
     * @Route("/{id}", name="place_delete", methods="DELETE")
     */
    public function place_delete(Place $place): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        if (!is_null($place)){
            $em->remove($place);
            $em->flush();
            $data = [];
            $code = JsonResponse::HTTP_NO_CONTENT;
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

    /**
     * @Route("/{latitude}/{longitude}/{range}", name="place_in_range", methods="GET")
     */
     function GetPlacesInRange($latitude, $longitude, $range) {

         $placesInRange = [];

        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository(Place::class)->findAll();

        foreach($places as $place) {
            $distance = $this->GetDistance($latitude, $longitude, $place->getLatitude(), $place->getLongitude());
            if($distance <= $range){
                $data = [
                'id' => $place->getId(),
                'name' => $place->getName(),
                'user_id' => $place->getUserId()->getId(),
                'category_id' => $place->getCategoryId()->getId(),
                'adress' => $place->getAdress(),
                'postal_code' => $place->getPostalCode(),
                'city' => $place->getCity(),
                'latitude' => $place->getLatitude(),
                'longitude' => $place->getLongitude(),
                'distance' => $distance
                ];
                array_push($placesInRange, $data);
            }
        }

        $code = JsonResponse::HTTP_OK;
        $json = json_encode($placesInRange, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
     }


    function GetDistance($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return ($miles * 1.609344);
    }

}

<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

/**
* @Route("/user", name="user")
*/

class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="user", methods="GET")
     */
    public function user_id(User $user): JsonResponse
    {
        if(is_null($user)) {
           $data = [];
           $code = JsonResponse::HTTP_NOT_FOUND;
        } else {
            $data = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'apikey' => $user->getApikey(),
                'categories' => $user->getCategories(),
                'places' => $user->getPlaces()
            ];
        }

        $code = JsonResponse::HTTP_OK;
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

    /**
     * @Route("", name="user_create", methods="POST")
     */
    public function user_create(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $input = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($input['mail']);
        $user->setApikey($input['apikey']);
        $em->persist($user);
        $em->flush();

         $data = [
                'id' => $user->getId(),
                'mail' => $user->getEmail(),
                'apikey' => $user->getApikey()
            ];
        $code = JsonResponse::HTTP_CREATED;

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     */
    public function user_delete(User $user): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        if (!is_null($user)){
            $em->remove($user);
            $em->flush();
            $data = [];
            $code = JsonResponse::HTTP_NO_CONTENT;
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

     /**
     * @Route("/{id}", name="user_update", methods="PUT")
     */
    public function user_update(User $user, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $input = json_decode($request->getContent(), true);

        if (!is_null($user)){
            $user->setEmail($input['mail']);
            $user->setApikey($input['apikey']);
            $em->flush();

            $data = [
                'id' => $user->getId(),
                'mail' => $user->getEmail(),
                'apikey' => $user->getApikey(),
                'categories' => $user->getCategories(),
                'places' => $user->getPlaces()
                ];
                $code = JsonResponse::HTTP_ACCEPTED;

                
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

}


<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Category;


/**
* @Route("/category", name="category")
*/
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category", methods="GET")
     */
    public function index(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $categorys = $em->getRepository(Category::class)->findAll();

        $data = [];
        foreach ($categorys as $category) {
            array_push($data, [
                'id' => $category->getId(),
                'nom' => $category->getName(),
                'user_id' => $category->getUserId()
            ]);
        }

        $code = JsonResponse::HTTP_OK;
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }


     /**
     * @Route("/", name="category_create", methods="POST")
     */
    public function category_create(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $input = json_decode($request->getContent(), true);

        $category = new Category();
        $category->setName($input['name']);

        $em->persist($category);
        $em->flush();

         $data = [
                'id' => $category->getId(),
                'nom' => $category->getName(),
                'user_id' => $category->getUserId()
            ];
        $code = JsonResponse::HTTP_CREATED;

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

    /**
     * @Route("/{id}", name="category_update", methods="PUT")
     */
    public function category_update(Category $category, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $input = json_decode($request->getContent(), true);

        if (!is_null($category)){
            $category->setName($input['name']);
            $data = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'user_id' => $category->getUserId()
            ];
            $code = JsonResponse::HTTP_ACCEPTED;

            $em->persist($category);
        $em->flush();
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

    /**
     * @Route("/{id}", name="category_delete", methods="DELETE")
     */
    public function category_delete(Category $category): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        if (!is_null($category)){
            $em->remove($category);
            $em->flush();
            $data = [];
            $code = JsonResponse::HTTP_NO_CONTENT;
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return new JsonResponse($json, $code, [], true);
    }

}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GhostController extends AbstractController
{
    /**
     * @Route("/ghost", name="ghost")
     */
    public function index(Request $request)
    {
        $httpClient = HttpClient::create();
        $url = $this->getParameter('ghostAPIUrl') . '/ghost/api/v3/content/posts?key=8c5e04861afd1411c5366bb1e1&include=authors,tags';
        if ($request->get('typ')) {
            $response = $httpClient->request('GET', $url . '&filter=tag:' . $request->get('typ') . '-' . $request->get('id') . '-' . $request->get('law'));
        } else {
            $response = $httpClient->request('GET', $url);
        }
        $content = $response->toArray();
        return $this->render('ghost/index.html.twig', [
            'controller_name' => 'GhostController',
            'content' => $content,
        ]);
    }
}

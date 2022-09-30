<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{

    #[Route("/helloRandom")]
    public function randomNameAction(): Response
    {
        return new Response(
            "<html><body><h1>Hello " .
            self::generateRandomName() .
            "</h1></body></html>"
        );
    }

    static function generateRandomName(): string
    {
        $nouns = [
            "Circle", "Cone", "Cylinder", "Ellipse", "Hexagon",
            "Irregular Shape", "Octagon", "Oval", "Parallelogram",
            "Pentagon", "Pyramid", "Rectangle", "Semicircle", "Sphere",
            "Square", "Star", "Trapezoid", "Triangle", "Wedge", "Whorl",
        ];
        $adjectives = [
            "Amusing", "Athletic", "Beautiful", "Brave", "Careless",
            "Clever", "Crafty", "Creative", "Cute", "Dependable",
            "Energetic", "Famous", "Friendly", "Graceful", "Helpful",
            "Humble", "Inconsiderate", "Likable", "Mid  Class", "Outgoing",
            "Poor", "Practical", "Rich", "Sad", "Skinny", "Successful", "Thin",
            "Ugly", "Wealth",
        ];
        return $adjectives[array_rand($adjectives)] .
            " " .
            $nouns[array_rand($nouns)];
    }

    #[Route("/hello/{name}")]
    public function nameAction(SessionInterface $session, $name = ""): Response
    {

        if ($name == "" and !$session->has('name')) {
            $name = self::generateRandomName();
        } else if ($session->has('name') and $name == "") {
            $name = $session->get('name');
        } else if ($name != "") {
            $session->set('name', $name);
        }

        return $this->render('hello/hello.html.twig', ['name' => $name]);
    }

}

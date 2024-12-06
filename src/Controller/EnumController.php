<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Enum\Genres;

class EnumController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }
    #[Route('/api/genres/enum/{locale}', name: 'genres_enum')]
    public function listGenres(string $locale): Response
    {
        return $this->json(Genres::list($this->translator, $locale), Response::HTTP_OK);
    }
}

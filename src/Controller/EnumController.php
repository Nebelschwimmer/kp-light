<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Enum\Genres;
use App\Enum\Gender;
use App\Enum\Specialty;

class EnumController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }
    #[Route('/api/genres/translations/{locale}', name: 'genres_list')]
    public function listGenres(string $locale): Response
    {
        return $this->json(Genres::list($this->translator, $locale), Response::HTTP_OK);
    }

    #[Route('/api/genders/translations/{locale}', name: 'genders_list')]
    public function listGenders(string $locale): Response
    {
        return $this->json(Gender::list($this->translator, $locale), Response::HTTP_OK);
    }
    #[Route('/api/specialties/translations/{locale}', name: 'specialties_list')]
    public function listSpecialties(string $locale): Response
    {
        return $this->json(Specialty::list($this->translator, $locale), Response::HTTP_OK);
    }

}

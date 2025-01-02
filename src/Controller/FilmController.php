<?php

namespace App\Controller;

use App\Dto\Entity\FilmDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use App\Model\Response\Entity\Film\FilmPaginateList;
use App\Model\Response\Entity\Film\FilmList;
use Psr\Log\LoggerInterface;
use App\Model\Response\Entity\Film\FilmDetail;
use App\Model\Response\Entity\Film\FilmForm;
use Nelmio\ApiDocBundle\Attribute\Model;
use App\Exception\NotFound\FilmNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Entity\FilmService;
use App\Dto\Entity\Query\FilmQueryDto;
use App\Model\Response\Validation\ValidationErrorList;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Validator\Entity\Film\FilmValidator;
use App\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Model\Response\Entity\Person\PersonList;
use App\Model\Response\Entity\Person\PersonDetail;
use App\Dto\Entity\ActorDto;
use App\Dto\Entity\DirectorDto;
use App\Dto\Common\FileNameSearchDto;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Schema;

#[OA\Tag(name: 'Film')]
class FilmController extends AbstractController
{
  public function __construct(
    private FilmService $filmService,
    private LoggerInterface $logger,
  ) {
  }
  /**
   * Find a film by id
   */
  #[Route(path: '/api/films/{id}/{locale}',
    name: 'api_film',
    methods: ['GET'],
    requirements: ['id' => '\d+']
  )
  ]
  #[OA\Response(
    response: 200,
    description: 'Successful response',
    content: new Model(type: FilmDetail::class)
  )]
  public function find(int $id, string $locale): Response
  {
    $status = Response::HTTP_OK;
    $data = null;

    try {
      $data = $this->filmService->get($id, $locale);
    } catch (FilmNotFoundException $e) {
      $status = Response::HTTP_NOT_FOUND;
      $this->logger->error($e);
    }

    return $this->json($data, $status);
  }

  /**
   * Find a film form by id
   */
  #[Route(path: '/api/films/{id}/form',
    name: 'api_film_form',
    methods: ['GET'],
    requirements: ['id' => '\d+']
  )
  ]
  #[OA\Response(
    response: 200,
    description: 'Successful response',
    content: new Model(type: FilmForm::class)
  )]
  public function findForm(int $id): Response
  {
    $status = Response::HTTP_OK;
    $data = null;

    try {
      $data = $this->filmService->findForm($id);
    } catch (FilmNotFoundException $e) {
      $status = Response::HTTP_NOT_FOUND;
      $this->logger->error($e);
    }

    return $this->json($data, $status);
  }

  /**
   * List all films
   */
  #[Route(path: '/api/films/list',
    name: 'api_film_list',
    methods: ['GET'],
  )
  ]
  #[OA\Response(
    response: 200,
    description: 'Successful response',
    content: new Model(type: FilmList::class)
  )]
  public function list(): Response
  {
    return $this->json($this->filmService->list());
  }

   /**
   * Find 5 latest films
   */
  #[Route(path: '/api/films/latest',
    name: 'api_film_latest',
    methods: ['GET'],
  )
  ]
  #[OA\Response(
    response: 200,
    description: 'Successful response',
    content: new Model(type: FilmList::class)
  )]
  public function latest(): Response
  {
    return $this->json($this->filmService->latest());
  }

  /**
   * Filter films by query params
   */
  #[Route(
    path: 'api/films/filter',
    name: 'api_film_filter',
    methods: ['GET']
  )]
  #[OA\Response(
    response: 200,
    description: 'Successful response',
    content: new Model(type: FilmPaginateList::class)
  )]

  public function filter(#[MapQueryString] ?FilmQueryDto $dto = new FilmQueryDto()): Response
  {
    return $this->json($this->filmService->filter($dto));
  }

  /**
   * Create a new film
   */
  #[Route(
    path: 'api/films',
    name: 'api_film_create',
    methods: ['POST']
  )]
  #[OA\Response(
    response: 200,
    description: 'A new film has been created',
    content: new Model(type: FilmForm::class)
  )]
  #[OA\Response(
    response: 400,
    description: 'Validation error',
    content: new Model(type: ValidationErrorList::class)
  )]
  #[OA\Response(response: 500, description: 'An error occurred while creating the film')]

  public function create(
    FilmValidator $validator,
    #[MapRequestPayload] ?FilmDto $dto,
  ): Response {
    $data = null;
    $status = Response::HTTP_OK;

    try {
      $validator->validate($dto);

      $data = $this->filmService->create($dto);
    } catch (ValidatorException $e) {
      $this->logger->error($e);
      $status = Response::HTTP_BAD_REQUEST;
      $data = $validator->getErrors();
    } catch (\Throwable $e) {
      $this->logger->error($e);
      $data = $e->getMessage();
      $status = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return $this->json($data, $status);
  }

  /**
   * Update a film by id
   */
  #[Route(
    path: 'api/films/{id}',
    name: 'api_film_update',
    methods: ['POST', 'PUT']
  )]
  #[OA\Response(
    response: 200,
    description: 'A film has been updated',
    content: new Model(type: FilmForm::class)
  )]
  #[OA\Response(
    response: 400,
    description: 'Validation error',
    content: new Model(type: ValidationErrorList::class)
  )]
  #[OA\Response(response: 500, description: 'An error occurred while updating the person')]
  public function update(
    int $id,
    FilmValidator $validator,
    #[MapRequestPayload] ?FilmDto $dto,
  ): Response {

    $data = null;
    $status = Response::HTTP_OK;

    try {
      $validator->validate($dto);

      $data = $this->filmService->update($id, $dto);
    } catch (ValidatorException $e) {
      $this->logger->error($e);
      $status = Response::HTTP_BAD_REQUEST;
      $data = $validator->getErrors();
    } catch (\Throwable $e) {
      $this->logger->error($e);
      $data = $e->getMessage();
      $status = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return $this->json($data, $status);
  }

  /**
   * Delete a film by id
   */
  #[Route(
    path: 'api/films/{id}',
    name: 'api_film_delete',
    methods: ['DELETE']
  )]
  #[OA\Response(
    response: 200,
    description: 'The film has been deleted',
  )]
  #[OA\Response(response: 500, description: 'An error occurred while deleting the film')]
  public function delete(
    int $id,
  ): Response {

    $data = null;
    $status = Response::HTTP_OK;

    try {
      $this->filmService->delete($id);
    } catch (\Throwable $e) {
      $this->logger->error($e);
      $data = $e->getMessage();
      $status = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return $this->json($data, $status);
  }

  /**
   * Upload a preview for a film
   */
  #[Route(
    path: 'api/films/{id}/preview',
    name: 'api_film_preview_upload',
    methods: ['POST']
  )]
  #[OA\Response(
    response: 200,
    description: 'Upload preview',
  )]
  #[RequestBody(
		content: [
				new MediaType(
						mediaType: 'multipart/form-data',
						schema: new Schema(properties: [
								new OA\Property(
										property: 'preview',
										type: 'file',
								),
						])
				),
		]
)]


  /**
   * Upload a gallery for a film
   */
  #[Route(
    path: 'api/films/{id}/gallery',
    name: 'api_film_gallery_upload',
    methods: ['POST']
  )]
  #[OA\Response(
    response: 200,
    description: 'Upload gallery',
  )]
  #[RequestBody(
		content: [
				new MediaType(
						mediaType: 'multipart/form-data',
						schema: new Schema(properties: [
								new OA\Property(
										property: 'gallery',
										type: 'file',
								),
						])
				),
		]
)]
  #[OA\Response(response: 500, description: 'An error occurred while uploading the gallery')]
  public function uploadGallery(
    int $id,
    Request $request,
  ): Response {
    $data = null;
    $status = Response::HTTP_OK;

    try {
      $files = $request->files->get('gallery');
      if (null === $files) {
        $status = Response::HTTP_BAD_REQUEST;
        $data = 'No files found in request. Did you forget to specify the formdata key "gallery"?';
        return $this->json($data, $status);
      }
      $data = $this->filmService->uploadGallery($id, $files);
    } catch (\Throwable $e) {
      $this->logger->error($e);
      $data = $e->getMessage();
      $status = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return $this->json($data, $status);
  }

  /**
   * Delete a picture or pictures from the film gallery by file name(s)
   */
  #[Route(
    path: 'api/films/{id}/gallery',
    name: 'api_film_gallery_delete',
    methods: ['DELETE']
  )]
  #[OA\Response(
    response: 200,
    description: 'Picture(s) deleted',
  )]
  #[OA\Response(response: 500, description: 'An error occurred while deleteing the picture(s)')]
  public function deleteGalleryPicture(
    int $id,
    #[MapRequestPayload] ?FileNameSearchDto $dto,
  ): Response {
    $data = null;
    $status = Response::HTTP_OK;

    try {
      if (empty($dto->fileNames)) {
        $status = Response::HTTP_BAD_REQUEST;
        $data = 'The request is empty. No file names found.';
        return $this->json($data, $status);
      }
      $data = $this->filmService->deleteFromGallery($id, $dto->fileNames);
    } catch (\Throwable $e) {
      $this->logger->error($e);
      $data = $e->getMessage();
      $status = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return $this->json($data, $status);
  }

  /**
   * List all actors of a film
   */
  #[Route(path: '/api/films/{id}/actors',
    name: 'api_film_actors',
    methods: ['GET'],
  )
  ]
  #[OA\Response(
    response: 200,
    description: 'Successful response',
    content: new Model(type: PersonList::class)
  )]
  public function listActors(int $id): Response
  {
    $data = null;
    $status = Response::HTTP_OK;
    try {
      $data = $this->filmService->listActors($id);
    } catch (\Throwable $e) {
      $this->logger->error($e);
      $data = $e->getMessage();
      $status = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return $this->json($data, $status);
  }

  /**
   * Show details about the film director
   */
  #[Route(path: '/api/films/{id}/director',
    name: 'api_film_director',
    methods: ['GET'],
  )
  ]
  #[OA\Response(
    response: 200,
    description: 'Successful response',
    content: new Model(type: PersonDetail::class)
  )]
  public function findDirector(int $id): Response
  {
    $data = null;
    $status = Response::HTTP_OK;
    try {
      $data = $this->filmService->findDirector($id);
    } catch (\Throwable $e) {
      $this->logger->error($e);
      $data = $e->getMessage();
      $status = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return $this->json($data, $status);
  }

}
<?php

namespace App\Controller;

use App\Dto\Entity\GenreDto;
use App\Model\Response\Entity\Genre\GenreForm;
use App\Model\Response\Validation\ValidationErrorList;
use App\Service\Validator\Entity\Genre\GenreValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Nelmio\ApiDocBundle\Attribute\Model;
use App\Model\Response\Entity\Genre\GenreDetail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Entity\GenreService;
use App\Exception\NotFound\GenreNotFoundException;
use App\Exception\ValidatorException;
use OpenApi\Attributes as OA;
use Psr\Log\LoggerInterface;
#[OA\Tag(name: 'Genre')]
class GenreController extends AbstractController
{
	public function __construct(
		private LoggerInterface $logger,
		private GenreService $genreService,
	) {
	}

	/**
	 * Find a genre by id
	 */
	#[Route(path: '/api/genres/{id}',
		name: 'api_genre',
		methods: ['GET'],
		requirements: ['id' => '\d+']
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: GenreDetail::class)
	)]
	public function find(int $id): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->genreService->get($id);
		} catch (GenreNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}

	/**
	 * List all genres
	 */
	#[Route(path: '/api/genres/list',
		name: 'api_genre_list',
		methods: ['GET'],
		requirements: ['id' => '\d+']
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: GenreDetail::class)
	)]
	public function list(): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->genreService->list();
		} catch (GenreNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}

	/**
	 * Create a new genre
	 */
	#[Route(
		path: 'api/genres',
		name: 'api_genre_create',
		methods: ['POST']
	)]
	#[OA\Response(
		response: 200,
		description: 'A new genre has been created',
		content: new Model(type: GenreForm::class)
	)]
	#[OA\Response(
		response: 400,
		description: 'Validation error',
		content: new Model(type: ValidationErrorList::class)
	)]
	#[OA\Response(response: 500, description: 'An error occurred while creating the person')]

	public function create(
		GenreValidator $validator,
		#[MapRequestPayload()] ?GenreDto $dto,
	): Response {
		$data = null;
		$status = Response::HTTP_OK;

		try {
			$validator->validate($dto);

			$data = $this->genreService->create($dto);
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
	 * Update Genre by Id
	 */
	#[Route(
		path: 'api/genres/{id}',
		name: 'api_genre_update',
		methods: ['POST', 'PUT']
	)]
	#[OA\Response(
		response: 200,
		description: 'A new genre has been updated',
		content: new Model(type: GenreForm::class)
	)]
	#[OA\Response(
		response: 400,
		description: 'Validation error',
		content: new Model(type: ValidationErrorList::class)
	)]
	#[OA\Response(response: 500, description: 'An error occurred while creating the person')]

	public function update(
		int $id,
		GenreValidator $validator,
		#[MapRequestPayload()] ?GenreDto $dto,
	): Response {
		$data = null;
		$status = Response::HTTP_OK;

		try {
			$validator->validate($dto);

			$data = $this->genreService->update($id, $dto);
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
	 * Delete Genre by Id
	 */
	#[Route(
		path: 'api/genres/{id}',
		name: 'api_genre_delete',
		methods: ['DELETE']
	)]
	#[OA\Response(
		response: 200,
		description: 'The genre has been deleted',
	)]
	#[OA\Response(response: 500, description: 'An error occurred while deleting the genre')]

	public function delete(
		int $id,
	): Response {

		$data = null;
		$status = Response::HTTP_OK;

		try {
			$this->genreService->delete($id);
		} catch (\Throwable $e) {
			$this->logger->error($e);
			$data = $e->getMessage();
			$status = Response::HTTP_INTERNAL_SERVER_ERROR;
		}

		return $this->json($data, $status);
	}



}

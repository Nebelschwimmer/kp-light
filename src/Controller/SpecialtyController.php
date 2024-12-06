<?php

namespace App\Controller;

use App\Dto\Entity\SpecialtyDto;
use App\Model\Response\Entity\Specialty\SpecialtyForm;
use App\Model\Response\Validation\ValidationErrorList;
use App\Service\Validator\Entity\Specialty\SpecialtyValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Nelmio\ApiDocBundle\Attribute\Model;
use App\Model\Response\Entity\Specialty\SpecialtyDetail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Entity\SpecialtyService;
use App\Exception\NotFound\SpecialtyNotFoundException;
use App\Exception\ValidatorException;
use OpenApi\Attributes as OA;
use Psr\Log\LoggerInterface;
#[OA\Tag(name: 'Specialty')]
class SpecialtyController extends AbstractController
{
	public function __construct(
		private LoggerInterface $logger,
		private SpecialtyService $specialtyService,
	) {
	}

	/**
	 * Find a specialty by id
	 */
	#[Route(path: '/api/specialties/{id}',
		name: 'api_specialty',
		methods: ['GET'],
		requirements: ['id' => '\d+']
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: SpecialtyDetail::class)
	)]
	public function find(int $id): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->specialtyService->get($id);
		} catch (SpecialtyNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}

	/**
	 * List all specialties
	 */
	#[Route(path: '/api/specialties/list',
		name: 'api_specialty_list',
		methods: ['GET'],
		requirements: ['id' => '\d+']
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: SpecialtyDetail::class)
	)]
	public function list(): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->specialtyService->list();
		} catch (SpecialtyNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}

	/**
	 * Create a new specialty
	 */
	#[Route(
		path: 'api/specialties',
		name: 'api_specialty_create',
		methods: ['POST']
	)]
	#[OA\Response(
		response: 200,
		description: 'A new specialty has been created',
		content: new Model(type: SpecialtyForm::class)
	)]
	#[OA\Response(
		response: 400,
		description: 'Validation error',
		content: new Model(type: ValidationErrorList::class)
	)]
	#[OA\Response(response: 500, description: 'An error occurred while creating the person')]

	public function create(
		SpecialtyValidator $validator,
		#[MapRequestPayload()] ?SpecialtyDto $dto,
	): Response {
		$data = null;
		$status = Response::HTTP_OK;

		try {
			$validator->validate($dto);

			$data = $this->specialtyService->create($dto);
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
	 * Update Specialty by Id
	 */
	#[Route(
		path: 'api/specialties/{id}',
		name: 'api_specialty_update',
		methods: ['POST', 'PUT']
	)]
	#[OA\Response(
		response: 200,
		description: 'A new specialty has been updated',
		content: new Model(type: SpecialtyForm::class)
	)]
	#[OA\Response(
		response: 400,
		description: 'Validation error',
		content: new Model(type: ValidationErrorList::class)
	)]
	#[OA\Response(response: 500, description: 'An error occurred while creating the person')]

	public function update(
		int $id,
		SpecialtyValidator $validator,
		#[MapRequestPayload()] ?SpecialtyDto $dto,
	): Response {
		$data = null;
		$status = Response::HTTP_OK;

		try {
			$validator->validate($dto);

			$data = $this->specialtyService->update($id, $dto);
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
	 * Delete Specialty by Id
	 */
	#[Route(
		path: 'api/specialties/{id}',
		name: 'api_specialty_delete',
		methods: ['DELETE']
	)]
	#[OA\Response(
		response: 200,
		description: 'The specialty has been deleted',
	)]
	#[OA\Response(response: 500, description: 'An error occurred while deleting the specialty')]

	public function delete(
		int $id,
	): Response {

		$data = null;
		$status = Response::HTTP_OK;

		try {
			$this->specialtyService->delete($id);
		} catch (\Throwable $e) {
			$this->logger->error($e);
			$data = $e->getMessage();
			$status = Response::HTTP_INTERNAL_SERVER_ERROR;
		}

		return $this->json($data, $status);
	}



}

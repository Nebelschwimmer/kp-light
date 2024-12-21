<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use App\Model\Response\Entity\Person\PersonPaginateList;
use App\Model\Response\Entity\Person\PersonList;
use Psr\Log\LoggerInterface;
use App\Model\Response\Entity\Person\PersonDetail;
use App\Model\Response\Entity\Person\PersonForm;
use Nelmio\ApiDocBundle\Attribute\Model;
use App\Exception\NotFound\PersonNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Entity\PersonService;
use App\Dto\Entity\Query\PersonQueryDto;
use App\Model\Response\Validation\ValidationErrorList;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Dto\Entity\PersonDto;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Validator\Entity\Person\PersonValidator;
use App\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Dto\Entity\PersonSpecialtyDto;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Schema;
#[OA\Tag(name: 'Person')]
class PersonController extends AbstractController
{
	public function __construct(
		private PersonService $personService,
		private LoggerInterface $logger,
	) {
	}
	/**
	 * Find a person by id
	 */
	#[Route(path: '/api/persons/{id}',
		name: 'api_person',
		methods: ['GET'],
		requirements: ['id' => '\d+']
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: PersonDetail::class)
	)]
	public function find(int $id): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->personService->get($id);
		} catch (PersonNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}
	/**
	 * Find a person's form by id
	 */

	#[Route(path: '/api/persons/{id}/form',
		name: 'api_person_form',
		methods: ['GET'],
		requirements: ['id' => '\d+']
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: PersonForm::class)
	)]
	public function findForm(int $id): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->personService->findForm($id);
		} catch (PersonNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}

	/**
	 * List all persons
	 */
	#[Route(path: '/api/persons/list',
		name: 'api_person_list',
		methods: ['GET'],
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: PersonList::class)
	)]
	public function list(): Response
	{
		return $this->json($this->personService->list());
	}

	/**
	 * Filter persons by query params
	 */
	#[Route(
		path: 'api/persons/filter',
		name: 'api_person_filter',
		methods: ['GET']
	)]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: PersonPaginateList::class)
	)]

	public function filter(#[MapQueryString] ?PersonQueryDto $dto = new PersonQueryDto()): Response
	{
		return $this->json($this->personService->filter($dto));
	}

	/**
	 * Create a new person
	 */
	#[Route(
		path: 'api/persons',
		name: 'api_person_create',
		methods: ['POST']
	)]
	#[OA\Response(
		response: 200,
		description: 'A new person has been created',
		content: new Model(type: PersonForm::class)
	)]
	#[OA\Response(
		response: 400,
		description: 'Validation error',
		content: new Model(type: ValidationErrorList::class)
	)]
	#[OA\Response(response: 500, description: 'An error occurred while creating the person')]

	public function create(
		PersonValidator $validator,
		#[MapRequestPayload] ?PersonDto $dto,
	): Response {
		$data = null;
		$status = Response::HTTP_OK;

		try {
			$validator->validate($dto);

			$data = $this->personService->create($dto);
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
	 * Update a person by id
	 */
	#[Route(
		path: 'api/persons/{id}',
		name: 'api_person_update',
		methods: ['POST', 'PUT']
	)]
	#[OA\Response(
		response: 200,
		description: 'A person has been updated',
		content: new Model(type: PersonForm::class)
	)]
	#[OA\Response(
		response: 400,
		description: 'Validation error',
		content: new Model(type: ValidationErrorList::class)
	)]
	#[OA\Response(response: 500, description: 'An error occurred while updating the person')]

	public function update(
		int $id,
		PersonValidator $validator,
		#[MapRequestPayload] ?PersonDto $dto,
	): Response {

		$data = null;
		$status = Response::HTTP_OK;

		try {
			$validator->validate($dto);

			$data = $this->personService->update($id, $dto);
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
	 * Delete a person by id
	 */
	#[Route(
		path: 'api/persons/{id}',
		name: 'api_person_delete',
		methods: ['DELETE']
	)]
	#[OA\Response(
		response: 200,
		description: 'The person has been deleted',
	)]
	#[OA\Response(response: 500, description: 'An error occurred while deleting the person')]

	public function delete(
		int $id,
	): Response {

		$data = null;
		$status = Response::HTTP_OK;

		try {
			$this->personService->delete($id);
		} catch (\Throwable $e) {
			$this->logger->error($e);
			$data = $e->getMessage();
			$status = Response::HTTP_INTERNAL_SERVER_ERROR;
		}

		return $this->json($data, $status);
	}

	/**
	 * Upload a photo of the person by their id
	 */

	#[Route(
		path: 'api/persons/{id}/photo',
		name: 'api_person_upload',
		methods: ['POST'],
		requirements: ['id' => '\d+']
	)]
	#[RequestBody(
		content: [
			new MediaType(
				mediaType: 'multipart/form-data',
				schema: new Schema(properties: [
					new OA\Property(
						property: 'photo',
						type: 'file',
					),
				])
			),
		]
	)]
	#[OA\Response(
		response: 200,
		description: 'Upload photo',
	)]
	#[OA\Response(response: 500, description: 'An error occurred while uploading the photo')]

	public function uploadPhoto(
		int $id,
		Request $request,
	): Response {
		$data = null;
		$status = Response::HTTP_OK;

		try {
			/** @var UploadedFile $photo */
			$photo = $request->files->get('photo');

			if (null === $photo) {
				$status = Response::HTTP_BAD_REQUEST;
				$data = 'No file found in request. Did you forget to specify the formdata key "photo"?';
				return $this->json($data, $status);
			}


			$data = $this->personService->uploadPhoto($id, $photo);
		} catch (\Throwable $e) {
			$this->logger->error($e);
			$data = $e->getMessage();
			$status = Response::HTTP_INTERNAL_SERVER_ERROR;
		}

		return $this->json($data, $status);
	}

	/**
	 * Delete the photo of a person by their id
	 */
	#[Route(
		path: 'api/persons/{id}/photo',
		name: 'api_person_delete_photo',
		methods: ['DELETE']
	)]
	#[OA\Response(
		response: 200,
		description: 'Delete photo if exists',
	)]
	#[OA\Response(response: 500, description: 'An error occurred while uploading the photo')]
	public function deletePhoto(
		int $id,
	): Response {
		$data = null;
		$status = Response::HTTP_OK;

		try {
			$data = $this->personService->deletePhoto($id);
		} catch (\Throwable $e) {
			$this->logger->error($e);
			$data = $e->getMessage();
			$status = Response::HTTP_INTERNAL_SERVER_ERROR;
		}

		return $this->json($data, $status);
	}
}

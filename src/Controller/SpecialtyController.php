<?php

namespace App\Controller;
use App\Exception\NotFound\PersonNotFoundException;
use App\Model\Response\Entity\Person\PersonDetail;
use App\Service\Entity\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Psr\Log\LoggerInterface;

class SpecialtyController extends AbstractController
{
	public function __construct(
		private LoggerInterface $logger,
		private PersonService $personService,
	) {
	}

	/**
	 * List all directors
	 */
	#[Route(path: '/api/directors/list',
		name: 'api_director_list',
		methods: ['GET'],
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: PersonDetail::class)
	)]
	#[OA\Tag(name: 'Director')]
	public function listDirectors(): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->personService->listDirectors();
		} catch (PersonNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}

	/**
	 * List all actors
	 */
	#[Route(path: '/api/actors/list',
		name: 'api_actor_list',
		methods: ['GET'],
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: PersonDetail::class)
	)]
	#[OA\Tag(name: 'Actor')]
	public function listActors(): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->personService->listActors();
		} catch (PersonNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}
	/**
	 * List all producers
	 */
	#[Route(path: '/api/producers/list',
		name: 'api_producer_list',
		methods: ['GET'],
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: PersonDetail::class)
	)]
	#[OA\Tag(name: 'Producer')]
	public function listProducers(): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->personService->listProducers();
		} catch (PersonNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}

	/**
	 * List all writers
	 */
	#[Route(path: '/api/writers/list',
		name: 'api_writer_list',
		methods: ['GET'],
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: PersonDetail::class)
	)]
	#[OA\Tag(name: 'Writer')]

	public function listWriters(): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->personService->listWriters();
		} catch (PersonNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}


	/**
	 * List all writers
	 */
	#[Route(path: '/api/composers/list',
		name: 'api_composer_list',
		methods: ['GET'],
	)
	]
	#[OA\Response(
		response: 200,
		description: 'Successful response',
		content: new Model(type: PersonDetail::class)
	)]
	#[OA\Tag(name: 'Writer')]

	public function listWComposers(): Response
	{
		$status = Response::HTTP_OK;
		$data = null;

		try {
			$data = $this->personService->listComposers();
		} catch (PersonNotFoundException $e) {
			$status = Response::HTTP_NOT_FOUND;
			$this->logger->error($e);
		}

		return $this->json($data, $status);
	}

}



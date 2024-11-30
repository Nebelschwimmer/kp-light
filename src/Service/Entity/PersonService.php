<?php

namespace App\Service\Entity;
use App\Dto\Entity\PersonDto;
use App\Exception\NotFound\FilmNotFoundException;
use App\Model\Response\Entity\Person\PersonList;
use App\Repository\FilmRepository;
use App\Repository\PersonRepository;
use App\Mapper\Entity\PersonMapper;
use App\Entity\Person;
use App\Model\Response\Entity\Person\PersonDetail;
use App\Model\Response\Entity\Person\PersonForm;
use App\Service\FileSystemService;
use App\Exception\NotFound\PersonNotFoundException;
use Doctrine\Common\Collections\Order;
use App\Model\Response\Entity\Person\PersonPaginateList;
use App\Dto\Entity\Query\PersonQueryDto;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Exception\NotFound\PhotoNotFoundException;
use App\Enum\PersonType;
class PersonService
{
	public function __construct(
		private PersonRepository $repository,
		private FilmRepository $filmRepository,
		private PersonMapper $personMapper,
		private FileSystemService $fileSystemService
	) {
	}
	public function get(int $id): PersonDetail
	{
		$person = $this->find($id);
		$personDetail = $this->personMapper
			->mapToDetail($person, new PersonDetail());

		return $personDetail;
	}

	public function findForm(int $id): PersonForm
	{
		$person = $this->find($id);
		$form = $this->personMapper->mapToForm($person, new PersonForm());

		return $form;
	}


	public function create(PersonDto $dto): PersonForm
	{
		$person = new Person();
		$person
			->setFirstname($dto->firstname)
			->setLastname($dto->lastname)
			->setBirthday($dto->birthday)
			->setGender($dto->genderId)
			->setType($dto->typeId)
		;

		$this->repository->store($person);

		return $this->findForm($person->getId());
	}

	public function update(int $id, PersonDto $dto): PersonForm
	{
		$person = $this->repository->find($id);

		if (null === $person) {
			throw new PersonNotFoundException();
		}

		$person->setFirstname($dto->firstname);
		$person->setLastname($dto->lastname);
		$person->setBirthday($dto->birthday);
		$person->setGender($dto->genderId);
		$person->setType($dto->typeId);

		$fims = $person->getFilms();
		$oldType = $person->getType();

		$newType = $dto->typeId;
		foreach ($fims as $film) {
			if ($oldType == PersonType::ACTOR->value && $newType == PersonType::DIRECTOR->value) {
				$film->setDirector($person);
				$this->filmRepository->store($film);
			} else if ($oldType == PersonType::DIRECTOR->value && $newType == PersonType::ACTOR->value) {
				$film->setDirector(null);
				$this->filmRepository->store($film);
			}
		}

		$this->repository->store($person);

		return $this->findForm($person->getId());
	}

	public function delete(int $id): void
	{
		$person = $this->find($id);
		$films = $person->getFilms();

		foreach ($films as $film) {
			$person->removeFilm($film);
		}

		$this->repository->remove($person);
	}

	public function uploadPhoto(int $id, UploadedFile $photo): PersonForm
	{
		$person = $this->find($id);
		$dirName = $this->specifyPhotoPath($person->getId());
		$photoFileName = $this->fileSystemService->upload($photo, $dirName);

		$this->setPhoto($person, $photoFileName);
		$this->repository->store($person);

		return $this->findForm($person->getId());
	}

	public function deletePhoto(int $id): PersonForm
	{
		$person = $this->find($id);
		$photo = $person->getPhoto();

		if (null === $photo) {
			throw new PhotoNotFoundException();
		}

		$fullPath = $this->getPhotoFullPath($person);
		$this->fileSystemService->removeFile($fullPath);
		$person->setPhoto('');
		$this->repository->store($person);

		return $this->findForm($person->getId());
	}

	public function list(): PersonList
	{
		$persons = $this->repository->findBy([], ['id' => Order::Ascending->value]);

		$items = array_map(
			fn(Person $person) => $this->personMapper->mapToListItem($person),
			$persons
		);

		return new PersonList($items);
	}

	public function listDirectors(): PersonList
	{
		$persons = $this->repository->findBy(['type' => PersonType::DIRECTOR->value], ['id' => Order::Ascending->value]);

		$items = array_map(
			fn(Person $person) => $this->personMapper->mapToListItem($person),
			$persons
		);

		return new PersonList($items);
	}

	public function listActors(): PersonList
	{
		$persons = $this->repository->findBy(['type' => PersonType::ACTOR->value], ['id' => Order::Ascending->value]);

		$items = array_map(
			fn(Person $person) => $this->personMapper->mapToListItem($person),
			$persons
		);

		return new PersonList($items);
	}

	public function filter(PersonQueryDto $personQueryDto): PersonPaginateList
	{
		$persons = $this->repository->filterByQueryParams($personQueryDto);
		$total = $this->repository->total();

		$items = array_map(
			fn(Person $person) => $this->personMapper->mapToDetail($person, new PersonDetail()),
			$persons
		);

		return new PersonPaginateList($items, $total);
	}

	private function setPhoto(Person $person, ?string $photo): void
	{
		$fullpath = $this->specifyPhotoPath($person->getId()) . DIRECTORY_SEPARATOR . $photo;
		$shortPath = $this->fileSystemService->getShortPath($fullpath);
		$person->setPhoto($shortPath);
	}

	private function getPhotoFullPath(Person $person): ?string
	{
		$fullPath = $this->fileSystemService->getPublicDir() . $person->getPhoto();

		return $fullPath;
	}

	private function specifyPhotoPath(int $id): string
	{
		$personUploadsBaseDir = $this->fileSystemService->getUploadsDirname('person');
		$stringId = strval($id);
		$subDirByIdPath = $personUploadsBaseDir . DIRECTORY_SEPARATOR . $stringId;
		$this->fileSystemService->createDir($subDirByIdPath);

		return $subDirByIdPath;
	}

	private function find(int $id): Person
	{
		$person = $this->repository->find($id);
		if (null === $person) {
			throw new PersonNotFoundException();
		}

		return $person;
	}

}
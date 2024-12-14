<?php

namespace App\Service\Entity;

use App\Dto\Entity\FilmDto;
use App\Exception\NotFound\PersonNotFoundException;
use App\Exception\NotFound\SpecialtyNotFoundException;
use App\Repository\FilmRepository;
use App\Mapper\Entity\FilmMapper;
use App\Model\Response\Entity\Film\FilmDetail;
use App\Model\Response\Entity\Film\FilmForm;
use App\Model\Response\Entity\Film\FilmList;
use App\Dto\Entity\Query\FilmQueryDto;
use App\Model\Response\Entity\Film\FilmPaginateList;
use App\Entity\Film;
use App\Repository\GenreRepository;
use App\Repository\PersonRepository;
use Doctrine\Common\Collections\Order;
use App\Exception\NotFound\FilmNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileSystemService;
use App\Model\Response\Entity\Person\PersonList;
use App\Entity\Person;
use App\Model\Response\Entity\Person\PersonDetail;
use App\Mapper\Entity\PersonMapper;
use App\Exception\NotFound\GenreNotFoundException;
use App\Enum\SpecialtyName;

class FilmService
{
  public function __construct(
    private FilmRepository $repository,
    private PersonRepository $personRepository,
    private GenreRepository $genreRepository,
    private FilmMapper $filmMapper,
    private PersonMapper $personMapper,
    private FileSystemService $fileSystemService
  ) {
  }
  public function get(int $id): FilmDetail
  {
    $filmDetail = $this->filmMapper
      ->mapToDetail($this->find($id), new FilmDetail());

    $shortPreviewPath = $this->getPreviewShortPath($id);
    $filmDetail->setPreview($shortPreviewPath);

    $galleryPaths = $this->setGalleryPaths($id);
    $filmDetail->setGallery($galleryPaths);

    return $filmDetail;
  }


  public function findForm(int $id): FilmForm
  {
    $film = $this->find($id);
    $form = $this->filmMapper->mapToForm($film, new FilmForm());

    $shortPreviewPath = $this->getPreviewShortPath($id);
    $form->setPreview($shortPreviewPath);

    $galleryPaths = $this->setGalleryPaths($id);
    $form->setGallery($galleryPaths);

    return $form;
  }

  public function list(): FilmList
  {
    $films = $this->repository->findBy([], ['id' => Order::Ascending->value]);

    $items = array_map(
      fn(Film $film) => $this->filmMapper->mapToListItem($film),
      $films
    );

    foreach ($items as $item) {
      $shortPreviewPath = $this->getPreviewShortPath($item->getId());
      $item->setPreview($shortPreviewPath);
    }

    return new FilmList($items);
  }

  public function listActors(int $id): PersonList
  {
    $film = $this->find($id);
    $actors = $film->getActors()->toArray();

    $items = array_map(
      fn(Person $actor) => $this->personMapper->mapToListItem($actor),
      $actors
    );

    return new PersonList($items);
  }

  public function findDirector(int $id): PersonDetail
  {
    $film = $this->find($id);
    $director = $film->getDirector();
    if (null === $director) {
      throw new PersonNotFoundException();
    }

    return $this->personMapper->mapToDetail($director, new PersonDetail());
  }

  public function addActor(int $filmId, int $actorId): FilmForm
  {
    $film = $this->find($filmId);
    $person = $this->personRepository->find($actorId);
    $actor = null;
    if (null === $person) {
      throw new PersonNotFoundException();
    }
    $specialties = $person->getSpecialties();
    foreach ($specialties as $specialty) {
      if ($specialty->getName() == SpecialtyName::ACTOR->value) {
        $actor = $person;
        break;
      }
    }
    if (null === $actor) {
      throw new SpecialtyNotFoundException();
    }

    $film->addActor($actor);
    $actor->addFilm($film);

    $this->repository->store($film);
    $this->personRepository->store($actor);

    return $this->findForm($filmId);
  }
  public function deleteActor(int $filmId, int $actorId): FilmForm
  {
    $film = $this->find($filmId);
    $actor = $this->personRepository->find( $actorId);

    if (null === $actor) {
      throw new PersonNotFoundException();
    }

    $film->removeActor($actor);
    $actor->removeFilm($film);

    $this->repository->store($film);
    $this->personRepository->store($actor);

    return $this->findForm($filmId);
  }

  public function addDirector(int $filmId, int $directorId): FilmForm
  {
    $film = $this->find($filmId);
    $person = $this->personRepository->find($directorId);

    $director = null;
    
    if (null === $person) {
      throw new PersonNotFoundException();
    }
    $specialties = $person->getSpecialties();
    foreach ($specialties as $specialty) {
      if ($specialty->getName() == SpecialtyName::DIRECTOR->value) {
        $director = $person;
        break;
      }
    }
    if (null === $director) {
      throw new SpecialtyNotFoundException();
    }
    $film->setDirector($director);
    $this->repository->store($film);
    
    $person->addFilm($film);
    $this->personRepository->store($person);
    
    return $this->findForm($filmId);
  }

  public function deleteDirector(int $filmId): FilmForm
  {
    $film = $this->find($filmId);
    $director = $film->getDirector();
    if (null === $director) {
      throw new PersonNotFoundException();
    }

    $film->setDirector(null);
    $director->removeFilm($film);

    $this->repository->store($film);
    $this->personRepository->store($director);

    return $this->findForm($filmId);
  }


  public function filter(FilmQueryDto $filmQueryDto): FilmPaginateList
  {
    $films = $this->repository->filterByQueryParams($filmQueryDto);
    $total = $this->repository->total();

    $items = array_map(
      fn(Film $film) => $this->filmMapper->mapToDetail($film, new FilmDetail()),
      $films
    );

    return new FilmPaginateList($items, $total);
  }

  public function create(FilmDto $dto): FilmForm
  {
    $film = new Film();
    $film
      ->setName($dto->name)
      ->setReleaseYear($dto->releaseYear);

    $genreId = $dto->genreId;
    if (null !== $genreId) {
      $genre = $this->genreRepository->find($genreId);
      if (null === $genre) {
        throw new GenreNotFoundException();
      }
      $film->setGenre($genre);
    }

    $this->repository->store($film);

    return $this->findForm($film->getId());
  }

  public function update(int $id, FilmDto $dto): FilmForm
  {
    $film = $this->find($id);
    $film
      ->setName($dto->name)
      ->setReleaseYear($dto->releaseYear);

    $genreId = $dto->genreId;
    if (null !== $genreId) {
      $genre = $this->genreRepository->find($genreId);
      if (null === $genre) {
        throw new GenreNotFoundException();
      }
      $film->setGenre($genre);
    }
    $this->repository->store($film);

    return $this->findForm($film->getId());
  }

  public function delete(int $id): void
  {
    $film = $this->find($id);
    $this->repository->remove($film);
  }

  public function uploadPreview(int $id, UploadedFile $preview): FilmForm
  {
    $film = $this->find($id);
    $dirName = $this->specifyFilmPreviewPath($film->getId());
    $this->fileSystemService->upload($preview, $dirName, 'preview');

    return $this->findForm($film->getId());
  }

  public function deletePreview(int $id): FilmForm
  {
    $film = $this->find($id);
    $fullPath = $this->getPreviewFileFullPath($id);

    $this->fileSystemService->removeFile($fullPath);

    $filmForm = $this->findForm(id: $film->getId());
    $filmForm->setPreview("");

    return $filmForm;
  }

  public function uploadGallery(int $id, array $files): FilmForm
  {
    $film = $this->find($id);
    $dirName = $this->specifyFilmGalleryPath($film->getId());
    foreach ($files as $index => $file) {
      $indexedFileName = 'picture' . '-' . $index + 1;
      $this->fileSystemService->upload($file, $dirName, $indexedFileName);
    }

    return $this->findForm($film->getId());
  }

  public function deleteFromGallery(int $id, array $fileNames): FilmForm
  {

    $film = $this->find($id);
    $dirName = $this->specifyFilmGalleryPath($film->getId());
    $foundPictures = [];
    foreach ($fileNames as $fileName) {
      $foundPictures[] = $this->fileSystemService->searchFiles($dirName, $fileName);
    }

    foreach ($foundPictures as $picture) {
      foreach ($picture as $file) {
        $this->fileSystemService->removeFile($file);
      }
    }

    return $this->findForm($film->getId());
  }

  private function setGalleryPaths(int $id): array
  {
    $film = $this->find($id);
    $galleryDirPath = $this->specifyFilmGalleryPath($id);
    $galleryFiles = $this->fileSystemService->searchFiles($galleryDirPath);
    $shortPaths = [];

    for ($index = 0; $index < count($galleryFiles); $index++) {
      $shortPaths[] = $this->getGalleryItemShortPath($film, $index);
    }

    return $shortPaths;
  }

  private function getPreviewShortPath($id): string
  {
    $fullpath = $this->getPreviewFileFullPath($id);
    $shortPath = '';
    if (file_exists($fullpath)) {
      $shortPath = $this->fileSystemService->getShortPath($fullpath);
    }

    return $shortPath;
  }

  private function specifyFilmPreviewPath(int $id): string
  {
    $subDirByIdPath = $this->createUploadsDir($id);

    $previewDirPath = $subDirByIdPath . DIRECTORY_SEPARATOR . 'preview';
    $this->fileSystemService->createDir($previewDirPath);

    return $previewDirPath;
  }

  private function specifyFilmGalleryPath(int $id): string
  {
    $subDirByIdPath = $this->createUploadsDir($id);

    $galleryDirPath = $subDirByIdPath . DIRECTORY_SEPARATOR . 'gallery';
    $this->fileSystemService->createDir($galleryDirPath);

    return $galleryDirPath;
  }

  private function createUploadsDir(int $id): string
  {
    $filmBaseUploadsDir = $this->fileSystemService->getUploadsDirname('film');

    $stringId = strval($id);
    $subDirByIdPath = $filmBaseUploadsDir . DIRECTORY_SEPARATOR . $stringId;

    $this->fileSystemService->createDir($subDirByIdPath);

    return $subDirByIdPath;
  }

  private function getPreviewFileFullPath(int $id): ?string
  {
    $previewPath = $this->specifyFilmPreviewPath($id);
    $previewDirFiles = $this->fileSystemService->searchFiles($previewPath);
    $previewFilePath = $previewDirFiles[0] ?? null;

    return $previewFilePath;
  }

  private function getGalleryItemShortPath(Film $film, int $index): string
  {
    $dirName = $this->specifyFilmGalleryPath($film->getId());
    $indexedFileName = 'picture' . '-' . $index + 1;
    $fullpath = $dirName . DIRECTORY_SEPARATOR . $indexedFileName;
    $shortPath = $this->fileSystemService->getShortPath($fullpath);

    return $shortPath;
  }

  private function find(int $id): Film
  {
    $film = $this->repository->find($id);
    if (null === $film) {
      throw new FilmNotFoundException();
    }

    return $film;
  }


}
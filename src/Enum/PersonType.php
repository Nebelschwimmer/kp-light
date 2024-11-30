<?php
namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum PersonType: int implements TranslatableInterface
{
  case ACTOR = 1;
  case DIRECTOR = 2;

  public function trans(TranslatorInterface $translator, ?string $locale = null): string
  {
    return match ($this) {
      self::ACTOR => $translator->trans('actor', locale: $locale, domain: 'person_type'),
      self::DIRECTOR => $translator->trans('director', locale: $locale, domain: 'person_type'),
    };
  }
}
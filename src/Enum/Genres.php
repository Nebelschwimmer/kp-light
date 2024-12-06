<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum Genres: int implements TranslatableInterface
{
    case DRAMA = 1;

    case ACTION = 2;

    case COMEDY = 3;

    case THRILLER = 4;

    case ROMANCE = 5;

    case FANTASY = 6;

    case SCIENCE_FICTION = 7;

    case HORROR = 8;

    case DOCUMENTARY = 9;




    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::DRAMA => $translator->trans('drama', locale: $locale, domain: 'genres'),
            self::ACTION => $translator->trans('action', locale: $locale, domain: 'genres'),
            self::COMEDY => $translator->trans('comedy', locale: $locale, domain: 'genres'),
            self::THRILLER => $translator->trans('thriller', locale: $locale, domain: 'genres'),
            self::ROMANCE => $translator->trans('romance', locale: $locale, domain: 'genres'),
            self::FANTASY => $translator->trans('fantasy', locale: $locale, domain: 'genres'),
            self::SCIENCE_FICTION => $translator->trans('science_fiction', locale: $locale, domain: 'genres'),
            self::HORROR => $translator->trans('horror', locale: $locale, domain: 'genres'),
            self::DOCUMENTARY => $translator->trans('documentary', locale: $locale, domain: 'genres'),
        };
    }

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function isValid(int $value): bool
    {
        return in_array($value, self::getValues(), true);
    }

    public static function list(?TranslatorInterface $translator = null, ?string $locale = null): array
    {
        return array_map(function (self $case) use ($translator, $locale) {
            return [
                'name' => $translator ? $case->trans($translator, $locale) : $case->name,
                'value' => $case->value,
            ];
        }, self::cases());
    }
}

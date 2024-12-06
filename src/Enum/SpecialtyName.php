<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum SpecialtyName: string implements TranslatableInterface
{
    case ACTOR = 'actor';
    case DIRECTOR = 'director';
    case PRODUCER = 'producer';
    case WRITER = 'writer';
    case COMPOSER = 'composer';
    case EDITOR = 'editor';

    case UNKNOWN = 'unknown';



    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::ACTOR => $translator->trans('actor', locale: $locale, domain: 'specialty_names'),
            self::DIRECTOR => $translator->trans('director', locale: $locale, domain: 'specialty_names'),
            self::PRODUCER => $translator->trans('producer', locale: $locale, domain: 'specialty_names'),
            self::WRITER => $translator->trans('writer', locale: $locale, domain: 'specialty_names'),
            self::COMPOSER => $translator->trans('composer', locale: $locale, domain: 'specialty_names'),
            self::EDITOR => $translator->trans('editor', locale: $locale, domain: 'specialty_names'),
            self::UNKNOWN => $translator->trans('unknown', locale: $locale, domain: 'specialty_names'),
        };
    }

    public static function list(?TranslatorInterface $translator = null, ?string $locale = null): array
    {
        return array_map(function (SpecialtyName $case) use ($translator, $locale) {
            return [
                'name' => $translator ? $case->trans($translator, $locale) : $case->name,
                'value' => $case->value,
            ];
        }, self::cases());
    }
}

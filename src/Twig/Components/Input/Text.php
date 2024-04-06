<?php

namespace App\Twig\Components\Input;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
//#[AsTwigComponent(template: 'components/Input/Text.html.twig')]
final class Text
{
    public mixed $row;
    public ?string $label = '';
}
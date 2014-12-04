<?php
use GetSky\ParserExpressions\Rules\AnyOf;
use GetSky\ParserExpressions\Rules\FirstOf;
use GetSky\ParserExpressions\Rules\Optional;
use GetSky\ParserExpressions\Rules\Range;
use GetSky\ParserExpressions\Rules\Sequence;

class TimeParser
{
    public function time() {
        return new FirstOf([$this->hhmmss(), $this->hh()]);
    }

    public function hhmmss() {
        return new Sequence(
            [
                $this->oneOrTwoDigits(),
                $this->dot(),
                $this->twoDigits(),
                new Optional([$this->dot(), $this->twoDigits()])
            ],
            'h(h):mm(:ss)'
        );
    }

    public function hh() {
        return new Sequence(
            [$this->twoDigits(), new Optional([$this->twoDigits(), new Optional($this->twoDigits())])],
            'hh(mm(ss))'
        );
    }

    public function oneOrTwoDigits() {
        return new FirstOf([$this->digit(), [$this->digit(), $this->digit()]], 'one or two digits');
    }

    public function twoDigits() {
        return new Sequence([$this->digit(), $this->digit()], 'two digits');
    }

    public function digit() {
        return new Range(0, 9, 'digit');
    }

    public function dot() {
        return new Optional(new AnyOf(':.-_', 'dot'));
    }
}

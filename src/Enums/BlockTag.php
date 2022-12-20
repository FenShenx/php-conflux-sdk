<?php

namespace Fenshenx\PhpConfluxSdk\Enums;

class BlockTag
{
    private static $LatestCommitted = 'latest_committed';

    private static $LatestVoted = 'latest_voted';

    private function __construct(
        private string $case
    )
    {

    }

    public function getCase()
    {
        return $this->case;
    }

    public static function latestCommitted()
    {
        return new self(self::$LatestCommitted);
    }
    public static function latestVoted()
    {
        return new self(self::$LatestVoted);
    }

    public static function getCases()
    {
        return [
            self::$LatestCommitted,
            self::$LatestVoted
        ];
    }
}
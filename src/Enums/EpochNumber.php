<?php

namespace Fenshenx\PhpConfluxSdk\Enums;

class EpochNumber
{
    private static $Earliest = "earliest";

    private static $LatestCheckpoint = "latest_checkpoint";

    private static $LatestFinalized = "latest_finalized";

    private static $LatestConfirmed = "latest_confirmed";

    private static $LatestState = "latest_state";

    private static $LatestMined = "latest_mined";

    private function __construct(
        private string $case
    )
    {

    }

    public function getCase()
    {
        return $this->case;
    }

    public static function earliest()
    {
        return new self(self::$Earliest);
    }

    public static function latestCheckpoint()
    {
        return new self(self::$LatestCheckpoint);
    }

    public static function latestFinalized()
    {
        return new self(self::$LatestFinalized);
    }
    public static function latestConfirmed()
    {
        return new self(self::$LatestConfirmed);
    }
    public static function latestState()
    {
        return new self(self::$LatestState);
    }
    public static function latestMined()
    {
        return new self(self::$LatestMined);
    }

    public static function getCases()
    {
        return [
            self::$Earliest,
            self::$LatestCheckpoint,
            self::$LatestFinalized,
            self::$LatestConfirmed,
            self::$LatestState,
            self::$LatestMined,
        ];
    }
}
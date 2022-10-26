<?php

namespace Fenshenx\PhpConfluxSdk\Enums;

enum EpochNumber: String
{
    case Earliest = "earliest";

    case LatestCheckpoint = "latest_checkpoint";

    case LatestFinalized = "latest_finalized";

    case LatestConfirmed = "latest_confirmed";

    case LatestState = "latest_state";

    case LatestMined = "latest_mined";
}
<?php

namespace Fenshenx\PhpConfluxSdk\Enums;

enum BlockTag: string
{
    case LatestCommitted = 'latest_committed';

    case LatestVoted = 'latest_voted';
}
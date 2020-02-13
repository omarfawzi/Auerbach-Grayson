<?php

namespace App\Factories;

use App\Transformers\ErrorTransformer;
use App\Transformers\MessageTransformer;
use App\Transformers\TokenTransformer;
use App\Transformers\UserTransformer;
use InvalidArgumentException;
use League\Fractal\TransformerAbstract;

class TransformerFactory
{
    /** @var UserTransformer $userTransformer */
    private $userTransformer;

    /** @var ErrorTransformer $errorTransformer */
    private $errorTransformer;

    /** @var TokenTransformer $tokenTransformer */
    private $tokenTransformer;

    /** @var MessageTransformer $messageTransformer */
    private $messageTransformer;

    /**
     * TransformerFactory constructor.
     *
     * @param UserTransformer    $userTransformer
     * @param ErrorTransformer   $errorTransformer
     * @param TokenTransformer   $tokenTransformer
     * @param MessageTransformer $messageTransformer
     */
    public function __construct(
        UserTransformer $userTransformer,
        ErrorTransformer $errorTransformer,
        TokenTransformer $tokenTransformer,
        MessageTransformer $messageTransformer
    ) {
        $this->userTransformer    = $userTransformer;
        $this->errorTransformer   = $errorTransformer;
        $this->tokenTransformer   = $tokenTransformer;
        $this->messageTransformer = $messageTransformer;
    }


    /**
     * @param string $transformer
     * @return ErrorTransformer|MessageTransformer|TokenTransformer|UserTransformer
     */
    public function make(string $transformer) : TransformerAbstract
    {
        switch ($transformer)
        {
            case ErrorTransformer::class:
                return $this->errorTransformer;
            case MessageTransformer::class:
                return $this->messageTransformer;
            case TokenTransformer::class:
                return $this->tokenTransformer;
            case UserTransformer::class:
                return $this->userTransformer;
            default:
                throw new InvalidArgumentException("Transformer $transformer not found");
        }
    }
}

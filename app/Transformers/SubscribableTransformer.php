<?php

namespace App\Transformers;

use App\Contracts\Subscribable;
use App\Factories\SubscribableFactory;
use League\Fractal\TransformerAbstract;

class SubscribableTransformer extends TransformerAbstract
{
    /** @var SubscribableFactory $subscribableFactory */
    protected $subscribableFactory;

    /**
     * SubscribableTransformer constructor.
     *
     * @param SubscribableFactory $subscribableFactory
     */
    public function __construct(SubscribableFactory $subscribableFactory)
    {
        $this->subscribableFactory = $subscribableFactory;
    }


    /**
     * @param Subscribable $subscribable
     * @return array
     */
    public function transform(Subscribable $subscribable) : array
    {
        return $this->subscribableFactory->make($subscribable)->transform($subscribable);
    }
}

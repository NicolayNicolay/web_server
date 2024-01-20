<?php

declare(strict_types=1);

namespace Modules\System\Resources;

class AbstractResource implements ResourceInterface
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}

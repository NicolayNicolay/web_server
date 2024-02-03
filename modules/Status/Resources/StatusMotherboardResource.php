<?php

declare(strict_types=1);

namespace Modules\Status\Resources;

use Modules\System\Resources\AbstractResource;

class StatusMotherboardResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            "motherboard" => $this->data['Motherboard'] ?? '',
            "switch"      => $this->data['I2C switch'] ?? '',
            "expander"    => $this->data['Expander'] ?? '',
            "tsensor"     => $this->data['Tsensor'] ?? '',
            "uart"        => $this->data['UART'] ?? '',
            "memory"      => $this->data['Memory'] ?? '',
            "fan"         => $this->data['FAN controller'] ?? '',
        ];
    }
}

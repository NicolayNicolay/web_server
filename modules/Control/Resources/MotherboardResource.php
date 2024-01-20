<?php

declare(strict_types=1);

namespace Modules\Control\Resources;

use Modules\System\Resources\AbstractResource;

class MotherboardResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'name'                         => $this->data['name'] ?? '',
            'sub_name'                     => $this->data['info'] ? $this->data['info']['P/n'] . ', Rev.:' . $this->data['info']['Rev'] . ', S/n:' . $this->data['info']['S/n'] . ', Date:' . $this->data['info']['Date'] : '',
            'el_v_carrierboards_status'    => $this->data['12v_carrierboards_status'] ?? '',
            'v_cpu_status'                 => $this->data['5v_cpu_status'] ?? '',
            'three_v_carrierboards_status' => $this->data['33v_carrierboards_status'] ?? '',
            'three_v_standby_voltage'      => $this->data['33v_standby_voltage'] ?? '',
            'three_v_main_voltage'         => $this->data['33v_main_voltage'] ?? '',
            'hotplug_status'               => $this->data['hotplug_status'] ?? '',
            'faults'                       => $this->getFaults(),
        ];
    }

    private function getFaults(): string
    {
        $result = [];
        if ($this->data['faults']) {
            foreach ($this->data['faults'] as $fault) {
                if (is_array($fault)) {
                    foreach ($fault as $item) {
                        $result[] = $item;
                    }
                } else {
                    $result[] = $fault;
                }
            }
        }
        return implode(', ', $result);
    }
}

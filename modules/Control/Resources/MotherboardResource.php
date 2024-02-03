<?php

declare(strict_types=1);

namespace Modules\Control\Resources;

use Modules\System\Resources\AbstractResource;
use Modules\Traites\DataTrait;

class MotherboardResource extends AbstractResource
{
    use DataTrait;

    public function toArray(): array
    {
        return [
            'name'                         => $this->data['name'] ?? '',
            'sub_name'                     => $this->data['info'] ? $this->data['info']['P/n'] . ', Rev.:' . $this->data['info']['Rev'] . ', S/n:' . $this->data['info']['S/n'] . ', Date:' . $this->data['info']['Date'] : '',
            'el_v_carrierboards_status'    => $this->getTableStatus($this->data['12v_carrierboards_status']),
            'v_cpu_status'                 => $this->getTableStatus($this->data['5v_cpu_status']),
            'three_v_carrierboards_status' => $this->getTableStatus($this->data['33v_carrierboards_status']),
            'three_v_standby_voltage'      => $this->getVoltage($this->data['33v_standby_voltage']),
            'three_v_main_voltage'         => $this->getVoltage($this->data['33v_main_voltage']),
            'hotplug_status'               => $this->getTableStatus($this->data['hotplug_status']),
            'faults'                       => $this->getFaults(),
        ];
    }

    private function getFaults(): array
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
        return [
            'value' => implode(', ', $result),
            'class' => $this->data['faults'] ? 'table-danger' : 'table-success',
        ];
    }

    private function getVoltage($value): array
    {
        $value = (float) $value;
        $class = '';
        $res = [
            'value' => $value,
            'class' => &$class,
        ];
        if ($value > 3.2 && $value < 3.4) {
            $class = 'table-success';
        }
        if (($value >= 3.1 && $value <= 3.2) || ($value >= 3.4 && $value <= 3.5)) {
            $class = 'table-warning';
        }
        if ($value < 3.1 || $value > 3.5) {
            $class = 'table-danger';
        }
        return $res;
    }
}

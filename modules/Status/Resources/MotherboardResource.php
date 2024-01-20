<?php

declare(strict_types=1);

namespace Modules\Status\Resources;

use Modules\System\Resources\AbstractResource;

class MotherboardResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'name'                       => $this->data['name'] ?? '',
            'sub_name'                   => $this->data['info'] ? $this->data['info']['P/n'] . ', Rev.:' . $this->data['info']['Rev'] . ', S/n:' . $this->data['info']['S/n'] . ', Date:' . $this->data['info']['Date'] : '',
            'fans_installed'             => $this->getFansInstalled(),
            'overheat_limit'             => $this->data['overheat_limit'] ? $this->data['overheat_limit'] . ' C' : '',
            'fans_mode'                  => $this->data['fans_mode'] ?? '',
            'fans_fault_min_speed'       => $this->data['fans_fault_min_speed'] ? $this->data['fans_fault_min_speed'] . ' rpm' : '',
            'fans_auto_min_pwm'          => $this->data['fans_auto_min_pwm'] ? $this->data['fans_auto_min_pwm'] . '%' : '',
            'temperatures'               => $this->getTemperature(),
            'temperature_start_auto'     => $this->data['temperature_start_auto'] ? $this->data['temperature_start_auto'] . ' C' : '',
            'temperature_operating_auto' => $this->data['temperature_operating_auto'] ? $this->data['temperature_operating_auto'] . ' C' : '',
            'temperature_mb'             => $this->data['temperature'] ?? '',
            'faults'                     => $this->getFaults(),
        ];
    }

    public function getFansInstalled(): string
    {
        $res = '';
        $count = count($this->data['fans_installed']);
        foreach ($this->data['fans_installed'] as $key => $datum) {
            if ($datum) {
                $res .= 'True';
            } else {
                $res .= 'False';
            }
            if ($key < ($count - 1)) {
                $res .= ', ';
            }
        }
        return $res;
    }

    public function getTemperature(): string
    {
        $result = '';
        if ($this->data['temperature_low']) {
            $result .= $this->data['temperature_low'] . '/';
        } else {
            $result .= '-/';
        }
        if ($this->data['temperature_high']) {
            $result .= $this->data['temperature_high'] . '/';
        } else {
            $result .= '-/';
        }
        if ($this->data['temperature_latch']) {
            $result .= $this->data['temperature_latch'];
        } else {
            $result .= '-';
        }
        return $result;
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

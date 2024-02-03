<?php

declare(strict_types=1);

namespace Modules\Status\Resources;

use Modules\System\Resources\AbstractResource;

class CarrierboardResource extends AbstractResource
{
    public function toArray(): array
    {
        return [
            'name'           => $this->data['name'] ?? '',
            'num'            => $this->data['num'] ?? '',
            'placement'      => $this->data['placement'] ?? '',
            'insert_status'  => $this->getInsertedStatus(),
            'sub_name'       => $this->data['info'] ? $this->data['info']['P/n'] . ', Rev.:' . $this->data['info']['Rev'] . ', S/n:' . $this->data['info']['S/n'] . ', Date:' . $this->data['info']['Date'] : '',
            'inserted'       => $this->getCpusInserted(),
            'status'         => $this->getCpusStatus(),
            'full_status'    => $this->getFullStatus(),
            'faults'         => $this->getFaults(),
            'temperature'    => $this->data['temperature'] ?? '',
            'overheat_limit' => $this->data['overheat_limit'] . ' C' ?? '',
            'v_cpu_status'   => $this->getCpuStatus(),
            'v_cpu_voltage'  => $this->getCpuVoltage(),
            'v_cpu_power'    => $this->getCpuPower(),
        ];
    }

    public function getCpusInserted(): ?string
    {
        $count_success = 0;
        if ($this->data['cpus_inserted']) {
            foreach ($this->data['cpus_inserted'] as $item) {
                if ($item) {
                    $count_success++;
                }
            }
            return $count_success . '/' . count($this->data['cpus_inserted']);
        }
        return '0/0';
    }

    public function getCpusStatus(): ?array
    {
        $count_success = 0;
        if ($this->data['cpus_status']) {
            foreach ($this->data['cpus_status'] as $item) {
                if ($item) {
                    $count_success++;
                }
            }
            $status = $count_success == count($this->data['cpus_status']) ? 1 : (count($this->data['faults']) > 0 ? 2 : 3);
            return [
                'value'  => $count_success . '/' . count($this->data['cpus_status']),
                'status' => $status,
                'class'  => $this->getClass($status),
            ];
        }
        return [
            'value'  => '0/0',
            'status' => 2,
            'class'  => $this->getClass(2),
        ];
    }

    public function getFaults(): ?string
    {
        if ($this->data['faults']) {
            return implode(",", $this->data['faults']);
        }
        return null;
    }

    public function getFullStatus(): ?array
    {
        $str = '[';
        $str_arr = [];
        $count_success = 0;
        if ($this->data['cpus_status']) {
            foreach ($this->data['cpus_status'] as $item) {
                if ($item) {
                    $str_arr[] = 'True';
                    $count_success++;
                } else {
                    $str_arr[] = 'False';
                }
            }
            $str .= implode(", ", $str_arr) . ']';
            $status = $count_success == count($this->data['cpus_status']) ? 1 : (count($this->data['faults']) > 0 ? 2 : 3);
            return [
                'value'  => $str,
                'status' => $status,
                'class'  => $this->getClass($status),
            ];
        }
        $str .= ']';
        return [
            'value'  => $str,
            'status' => null,
            'class'  => null,
        ];
    }

    public function getCpuStatus(): array
    {
        if (in_array('CPUs power fault', $this->data['faults']) || in_array('CPUs no power, powered off or overheated', $this->data['faults'])) {
            return [
                'value'  => 'Fault',
                'status' => 2,
                'class'  => $this->getClass(2),
            ];
        } else {
            return [
                'value'  => 'Good',
                'status' => 1,
                'class'  => $this->getClass(1),
            ];
        }
    }

    public function getCpuVoltage(): ?array
    {
        if ($this->data['5v_cpu_voltage_v'] || $this->data['5v_cpu_power_w'] == 0) {
            $status = ((double) $this->data['5v_cpu_voltage_v'] > 4.75 && (double) $this->data['5v_cpu_voltage_v'] < 5.25) ? 1 : 2;
            return [
                'value'  => $this->data['5v_cpu_voltage_v'],
                'status' => $status,
                'class'  => $this->getClass($status),
            ];
        }
        return null;
    }

    public function getCpuPower(): ?array
    {
        if ($this->data['5v_cpu_power_w'] || $this->data['5v_cpu_power_w'] == 0) {
            $status = (double) $this->data['5v_cpu_power_w'] < 100 ? 1 : 2;
            return [
                'value'  => $this->data['5v_cpu_power_w'],
                'status' => $status,
                'class'  => $this->getClass($status),
            ];
        }
        return null;
    }

    public function getClass($value): string
    {
        return match ($value) {
            1 => 'table-success',
            2 => 'table-danger',
            3 => 'table-secondary',
        };
    }

    public function getInsertedStatus(): array
    {
        $res = [
            'value' => $this->data['insert_status'],
        ];
        $res['class'] = match ($this->data['insert_status']) {
            'Inserted' => $this->getClass(1),
            'Absent' => $this->getClass(2),
            default => $this->getClass(3),
        };
        return $res;
    }
}

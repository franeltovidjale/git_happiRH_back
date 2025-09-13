<?php

namespace App\Services;

use App\Enums\EnterpriseOptionKey;
use App\Models\Option;
use Illuminate\Database\Eloquent\Collection;

use function Pest\Laravel\json;

class OptionService
{
    /**
     * Fetch a list of options with optional filters.
     */
    public function fetchList(): Collection
    {
        $enterprise = activeEnterprise();

        $query = Option::forEnterprise($enterprise->id);


        return $query->orderBy('key')->get();
    }

    /**
     * Update an option value.
     */
    public function update(string $key, array $value): Option
    {
        $enterprise = activeEnterprise();

        $option = Option::forEnterprise($enterprise->id)
            ->where('key', $key)
            ->first();

        if (!$option) {
            throw new \Exception('Option non trouvée');
        }

        $option->update([
            'value' => $value,
        ]);

        return $option->fresh();
    }

    public function createDefaultOptions(int $enterpriseId): void
    {
        $defaultOptions = [
            EnterpriseOptionKey::StartWorkTime->value => '09:00',
            EnterpriseOptionKey::EndWorkTime->value => '17:00',
            EnterpriseOptionKey::WorkDays->value => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
            EnterpriseOptionKey::RestMinute->value => 120,
        ];

        foreach ($defaultOptions as $key => $value) {
            $type = (EnterpriseOptionKey::from($key))->type();
            if ($type === 'array') {
                $value = is_string($value) ? $value : json_encode($value);
            }
            Option::updateOrCreate(
                [
                    'enterprise_id' => $enterpriseId,
                    'key' => $key,
                ],
                [
                    'value' => $value,
                    'label' => EnterpriseOptionKey::from($key)->label(),
                    'description' => (EnterpriseOptionKey::from($key))->description(),
                    'type' => $type,

                ]
            );
        }
    }

    /**
     * Get all options as a key => value array.
     */
    public function asArray(): array
    {
        return $this->fetchList()
            ->mapWithKeys(function (Option $option) {
                $keyValue = $option->key instanceof EnterpriseOptionKey ? $option->key->value : $option->key;
                return [$keyValue => $option->value];
            })
            ->toArray();
    }
}

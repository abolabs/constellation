<?php

namespace App\Rules\ServiceInstancesDep;

use App\Models\ServiceInstance;
use Illuminate\Contracts\Validation\Rule;

class ServiceInstancesHasSameEnv implements Rule
{
    private $data;

    /**
     * Constructor.
     */
    public function __construct(array $data)
    {
        $this->data = collect($data);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $sourceInstance = ServiceInstance::find($value, ['environnement_id']);
            $depInstance = ServiceInstance::find($this->data->get('instance_dep_id'), ['environnement_id']);

            return $sourceInstance->environnement_id == $depInstance->environnement_id;
        } catch (\Exception $exception) {
            \Log::warning($exception);

            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Source instance and dependency should be on the same environnement.';
    }
}

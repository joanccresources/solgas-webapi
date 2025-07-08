<?php

namespace App\Actions\v1\Helpers\Max;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class MaxElementUseCase
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Execute the use case.
     *
     * @return int
     */
    public function execute()
    {
        try {
            return $this->getMaxValue();
        } catch (ModelNotFoundException $e) {
            // Handle the case when the model is not found
            return 1;
        }
    }

    /**
     * Get the maximum value of the element.
     *
     * @return int
     */
    protected function getMaxValue()
    {
        $value = 1;

        // Retrieve the maximum value from the database
        $maxValue = $this->model->max('value');

        if ($maxValue !== null) {
            $value = $maxValue + 1;
        }

        return $value;
    }
}

<?php

namespace App\Contracts;

interface Documentable
{
    /**
     * Get the documents for this model.
     */
    public function documents();

    /**
     * Get the enterprise ID for this documentable model.
     */
    public function getEnterpriseId(): int;

    /**
     * Get the model's ID.
     */
    public function getId(): int;
}

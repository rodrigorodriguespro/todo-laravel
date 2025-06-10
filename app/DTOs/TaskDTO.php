<?php

namespace App\DTOs;

use Carbon\Carbon;

class TaskDTO {
    public function __construct(
        public string $title,
        public ?string $description,
        public string $status,
        public ?Carbon $deadline,
    ) {}
}

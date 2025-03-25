<?php
declare(strict_types=1);

namespace App\Types;

class TPayloadJobs {

	public function __construct(
		private int $jobId,
	) {
	}

}